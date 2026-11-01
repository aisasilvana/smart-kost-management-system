<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\RoomAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BillController extends Controller
{
    /**
     * Menampilkan daftar tagihan milik Owner.
     */
    public function index()
    {
        $ownerId = auth()->id();

        $bills = Bill::with([
            'roomAssignment.tenant.user',
            'roomAssignment.room.kost',
            'payments',
        ])
            ->whereHas('roomAssignment.room.kost', function ($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->latest()
            ->get();

        $totalBills = $bills->count();

        $unpaidBills = $bills->where('status', 'unpaid')->count();

        $paidBills = $bills->where('status', 'paid')->count();

        $totalUnpaid = $bills
            ->where('status', 'unpaid')
            ->sum('amount');

        return view('owner.bills.index', compact(
            'bills',
            'totalBills',
            'unpaidBills',
            'paidBills',
            'totalUnpaid'
        ));
    }

    /**
     * Menampilkan formulir pembuatan tagihan.
     */
    public function create()
    {
        $ownerId = auth()->id();

        $assignments = RoomAssignment::with([
            'tenant.user',
            'room.kost',
        ])
            ->where('status', 'active')
            ->whereHas('room.kost', function ($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->orderByDesc('start_date')
            ->get();

        return view('owner.bills.create', compact('assignments'));
    }

    /**
     * Menyimpan tagihan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_assignment_id' => [
                'required',
                'integer',
                'exists:room_assignments,id',
            ],
            'billing_month' => [
                'required',
                'date_format:Y-m',
            ],
            'due_date' => [
                'required',
                'date',
            ],
        ], [
            'room_assignment_id.required' => 'Silakan pilih penghuni.',
            'room_assignment_id.exists' => 'Data penempatan tidak ditemukan.',
            'billing_month.required' => 'Bulan tagihan wajib dipilih.',
            'billing_month.date_format' => 'Format bulan tagihan tidak valid.',
            'due_date.required' => 'Tanggal jatuh tempo wajib diisi.',
            'due_date.date' => 'Format tanggal jatuh tempo tidak valid.',
        ]);

        // Kolom billing_month di database bertipe DATE.
        // Contoh: 2026-10 diubah menjadi 2026-10-01.
        $billingMonth = $validated['billing_month'] . '-01';

        DB::transaction(function () use ($validated, $billingMonth) {

            $ownerId = auth()->id();

            $assignment = RoomAssignment::with([
                'room.kost',
                'tenant',
            ])
                ->where('id', $validated['room_assignment_id'])
                ->where('status', 'active')
                ->whereHas('room.kost', function ($query) use ($ownerId) {
                    $query->where('owner_id', $ownerId);
                })
                ->lockForUpdate()
                ->first();

            if (!$assignment) {
                throw ValidationException::withMessages([
                    'room_assignment_id' =>
                        'Penempatan tidak ditemukan, sudah berakhir, atau bukan milik Anda.',
                ]);
            }

            $existingBill = Bill::where(
                'room_assignment_id',
                $assignment->id
            )
                ->where('billing_month', $billingMonth)
                ->exists();

            if ($existingBill) {
                throw ValidationException::withMessages([
                    'billing_month' =>
                        'Tagihan untuk penghuni dan bulan tersebut sudah dibuat.',
                ]);
            }

            $amount = $assignment->room->monthly_price;

            Bill::create([
                'room_assignment_id' => $assignment->id,
                'billing_month' => $billingMonth,
                'amount' => $amount,
                'due_date' => $validated['due_date'],
                'status' => 'unpaid',
            ]);
        });

        return redirect()
            ->route('owner.bills.index')
            ->with('success', 'Tagihan bulanan berhasil dibuat.');
    }
}
