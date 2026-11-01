<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use App\Exports\IncomeExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Menampilkan pembayaran yang masuk untuk Owner.
     */
    public function index()
    {
        $ownerId = auth()->id();

        $payments = Payment::with([
            'bill.roomAssignment.tenant.user',
            'bill.roomAssignment.room.kost',
            'verifiedBy',
        ])
            ->whereHas('bill.roomAssignment.room.kost', function ($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->latest()
            ->get();

        $totalPayments = $payments->count();
        $pendingPayments = $payments->where('status', 'pending')->count();
        $approvedPayments = $payments->where('status', 'approved')->count();
        $rejectedPayments = $payments->where('status', 'rejected')->count();

        return view('owner.payments.index', compact(
            'payments',
            'totalPayments',
            'pendingPayments',
            'approvedPayments',
            'rejectedPayments'
        ));
    }

    /**
     * Menampilkan tagihan milik Tenant.
     */
    public function tenantIndex()
    {
        $tenant = auth()->user()->tenant;

        abort_unless($tenant, 403, 'Data penghuni tidak ditemukan.');

        $bills = Bill::with([
            'roomAssignment.room.kost',
            'payments',
        ])
            ->whereHas('roomAssignment', function ($query) use ($tenant) {
                $query->where('tenant_id', $tenant->id);
            })
            ->latest()
            ->get();

        return view('tenant.payments.index', compact('bills'));
    }

    /**
     * Tenant mengirim bukti pembayaran.
     */
    public function store(Request $request, Bill $bill)
    {
        $tenant = auth()->user()->tenant;

        abort_unless($tenant, 403, 'Data penghuni tidak ditemukan.');

        $belongsToTenant = $bill->roomAssignment()
            ->where('tenant_id', $tenant->id)
            ->exists();

        abort_unless($belongsToTenant, 403);

        $validated = $request->validate([
            'proof' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'payment_method' => ['required', 'in:bank_transfer,cash,e_wallet'],
        ], [
            'proof.required' => 'Bukti pembayaran wajib diunggah.',
            'proof.image' => 'File harus berupa gambar.',
            'proof.mimes' => 'Format bukti harus JPG, JPEG, atau PNG.',
            'proof.max' => 'Ukuran gambar maksimal 2 MB.',
            'payment_method.required' => 'Pilih metode pembayaran.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
        ]);

        if ($bill->status === 'paid') {
            throw ValidationException::withMessages([
                'proof' => 'Tagihan ini sudah lunas.',
            ]);
        }

        $pendingPayment = $bill->payments()
            ->where('status', 'pending')
            ->exists();

        if ($pendingPayment) {
            throw ValidationException::withMessages([
                'proof' => 'Bukti pembayaran sebelumnya masih menunggu verifikasi.',
            ]);
        }

        $proofPath = $request->file('proof')
            ->store('payment-proofs', 'public');

        try {
            Payment::create([
                'bill_id' => $bill->id,
                'amount' => $bill->amount,
                'payment_method' => $validated['payment_method'],
                'proof_path' => $proofPath,
                'status' => 'pending',
                'verified_by' => null,
                'verified_at' => null,
                'rejection_reason' => null,
            ]);
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($proofPath);
            throw $exception;
        }

        return redirect()
            ->route('tenant.payments.index')
            ->with('success', 'Bukti pembayaran berhasil dikirim dan menunggu verifikasi Owner.');
    }

    /**
     * Owner menyetujui pembayaran.
     */
    public function verify(Payment $payment)
    {
        $ownerId = auth()->id();

        $payment->load('bill.roomAssignment.room.kost');

        abort_unless(
            $payment->bill->roomAssignment->room->kost->owner_id === $ownerId,
            403
        );

        if ($payment->status !== 'pending') {
            return redirect()
                ->route('owner.payments.index')
                ->with('error', 'Pembayaran ini sudah diproses.');
        }

        DB::transaction(function () use ($payment) {
            $lockedPayment = Payment::where('id', $payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPayment->status !== 'pending') {
                throw ValidationException::withMessages([
                    'payment' => 'Pembayaran ini sudah diproses.',
                ]);
            }

            $lockedBill = Bill::where('id', $lockedPayment->bill_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedBill->status === 'paid') {
                throw ValidationException::withMessages([
                    'payment' => 'Tagihan ini sudah lunas.',
                ]);
            }

            $lockedPayment->update([
                'status' => 'approved',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'rejection_reason' => null,
            ]);

            $lockedBill->update([
                'status' => 'paid',
            ]);
        });

        return redirect()
            ->route('owner.payments.index')
            ->with('success', 'Pembayaran berhasil diverifikasi dan tagihan telah lunas.');
    }

    /**
     * Owner menolak pembayaran.
     */
    public function reject(Request $request, Payment $payment)
    {
        $ownerId = auth()->id();

        $payment->load('bill.roomAssignment.room.kost');

        abort_unless(
            $payment->bill->roomAssignment->room->kost->owner_id === $ownerId,
            403
        );

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if ($payment->status !== 'pending') {
            return redirect()
                ->route('owner.payments.index')
                ->with('error', 'Pembayaran ini sudah diproses.');
        }

        DB::transaction(function () use ($payment, $validated) {
            $lockedPayment = Payment::where('id', $payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPayment->status !== 'pending') {
                throw ValidationException::withMessages([
                    'payment' => 'Pembayaran ini sudah diproses.',
                ]);
            }

            $lockedPayment->update([
                'status' => 'rejected',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'rejection_reason' => $validated['rejection_reason'],
            ]);
        });

        return redirect()
            ->route('owner.payments.index')
            ->with('success', 'Pembayaran ditolak. Tenant dapat mengirim bukti pembayaran baru.');
    }

    /**
     * Validasi filter laporan pemasukan.
     */
    private function validateIncomeFilter(Request $request): array
    {
        return $request->validate([
            'month' => ['nullable', 'integer', 'between:1,12'],
            'year' => ['nullable', 'integer', 'between:2020,2100'],
        ]);
    }

    /**
     * Mengambil data pemasukan yang sudah disetujui milik Owner.
     */
    private function getIncomePayments(int $ownerId, int $year, ?int $month = null)
    {
        $query = Payment::with([
            'bill.roomAssignment.tenant.user',
            'bill.roomAssignment.room.kost',
            'verifiedBy',
        ])
            ->where('status', 'approved')
            ->whereNotNull('verified_at')
            ->whereHas('bill.roomAssignment.room.kost', function ($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->whereYear('verified_at', $year);

        if ($month !== null) {
            $query->whereMonth('verified_at', $month);
        }

        return $query->orderByDesc('verified_at')->get();
    }

    /**
     * Menampilkan rekap pemasukan Owner.
     */
    public function income(Request $request)
    {
        $ownerId = auth()->id();

        $validated = $this->validateIncomeFilter($request);

        $year = (int) ($validated['year'] ?? now()->year);
        $month = isset($validated['month'])
            ? (int) $validated['month']
            : null;

        $yearPayments = $this->getIncomePayments($ownerId, $year);

        $monthlyIncome = collect(range(1, 12))->map(function ($monthNumber) use ($yearPayments) {
            $monthlyPayments = $yearPayments->filter(function ($payment) use ($monthNumber) {
                return (int) $payment->verified_at->format('n') === $monthNumber;
            });

            return [
                'month' => $monthNumber,
                'name' => \Carbon\Carbon::create()
                    ->month($monthNumber)
                    ->translatedFormat('F'),
                'total' => $monthlyPayments->sum('amount'),
                'transactions' => $monthlyPayments->count(),
            ];
        });

        $payments = $month
            ? $yearPayments->filter(function ($payment) use ($month) {
                return (int) $payment->verified_at->format('n') === $month;
            })->values()
            : $yearPayments;

        $totalIncome = $payments->sum('amount');
        $transactionCount = $payments->count();

        return view('owner.income.index', compact(
            'payments',
            'monthlyIncome',
            'totalIncome',
            'transactionCount',
            'month',
            'year'
        ));
    }

    /**
     * Export laporan pemasukan ke Excel.
     */
    public function exportExcel(Request $request)
    {
        $ownerId = auth()->id();

        $validated = $this->validateIncomeFilter($request);

        $year = (int) ($validated['year'] ?? now()->year);
        $month = isset($validated['month'])
            ? (int) $validated['month']
            : null;

        $payments = $this->getIncomePayments($ownerId, $year, $month);

        $filename = 'laporan-pemasukan-' . $year;

        if ($month !== null) {
            $filename .= '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
        }

        $filename .= '.xlsx';

        return Excel::download(
            new IncomeExport($payments),
            $filename
        );
    }

    /**
     * Export laporan pemasukan ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $ownerId = auth()->id();

        $validated = $this->validateIncomeFilter($request);

        $year = (int) ($validated['year'] ?? now()->year);
        $month = isset($validated['month'])
            ? (int) $validated['month']
            : null;

        $payments = $this->getIncomePayments($ownerId, $year, $month);

        $totalIncome = $payments->sum('amount');
        $transactionCount = $payments->count();

        $pdf = Pdf::loadView('owner.income.pdf', compact(
            'payments',
            'totalIncome',
            'transactionCount',
            'month',
            'year'
        ))->setPaper('a4', 'landscape');

        $filename = 'laporan-pemasukan-' . $year;

        if ($month !== null) {
            $filename .= '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
        }

        return $pdf->download($filename . '.pdf');
    }
}
