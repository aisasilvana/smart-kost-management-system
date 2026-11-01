
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\RoomAssignmentController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PaymentController;

use App\Models\Kost;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Payment;


// HALAMAN UTAMA
Route::get('/', function () {
    return view('welcome');
});


// REDIRECT DASHBOARD BERDASARKAN ROLE
Route::get('/dashboard', function () {

    $user = auth()->user();

    if ($user->role === 'owner') {
        return redirect()->route('owner.dashboard');
    }

    if ($user->role === 'tenant') {
        return redirect()->route('tenant.dashboard');
    }

    abort(403, 'Role pengguna tidak dikenali.');

})->middleware(['auth', 'verified'])->name('dashboard');


// OWNER
Route::middleware(['auth', 'verified', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        // DASHBOARD OWNER
        Route::get('/dashboard', function () {

            $userId = auth()->id();

            // STATISTIK PROPERTI
            $kosts = Kost::where('owner_id', $userId)->count();

            $rooms = Room::whereHas('kost', function ($query) use ($userId) {
                $query->where('owner_id', $userId);
            })->count();

            $tenants = Tenant::where('owner_id', $userId)->count();

            $availableRooms = Room::whereHas('kost', function ($query) use ($userId) {
                $query->where('owner_id', $userId);
            })
                ->where('status', 'available')
                ->count();

            // KAMAR TERISI
            $occupiedRooms = max(0, $rooms - $availableRooms);

            // PERSENTASE KETERISIAN KAMAR
            $occupancyRate = $rooms > 0
                ? round(($occupiedRooms / $rooms) * 100, 1)
                : 0;

            // PEMASUKAN BULAN INI
            $monthlyIncome = Payment::where('status', 'approved')
                ->whereNotNull('verified_at')
                ->whereHas('bill.roomAssignment.room.kost', function ($query) use ($userId) {
                    $query->where('owner_id', $userId);
                })
                ->whereMonth('verified_at', now()->month)
                ->whereYear('verified_at', now()->year)
                ->sum('amount');

            // JUMLAH TRANSAKSI BULAN INI
            $monthlyTransactions = Payment::where('status', 'approved')
                ->whereNotNull('verified_at')
                ->whereHas('bill.roomAssignment.room.kost', function ($query) use ($userId) {
                    $query->where('owner_id', $userId);
                })
                ->whereMonth('verified_at', now()->month)
                ->whereYear('verified_at', now()->year)
                ->count();

            // PEMBAYARAN MENUNGGU VERIFIKASI
            $pendingPayments = Payment::where('status', 'pending')
                ->whereHas('bill.roomAssignment.room.kost', function ($query) use ($userId) {
                    $query->where('owner_id', $userId);
                })
                ->count();

            // AKTIVITAS PEMBAYARAN TERBARU
            $recentPayments = Payment::with([
                'bill.roomAssignment.tenant.user',
                'bill.roomAssignment.room.kost',
            ])
                ->whereHas('bill.roomAssignment.room.kost', function ($query) use ($userId) {
                    $query->where('owner_id', $userId);
                })
                ->latest()
                ->take(5)
                ->get();

            return view('owner.dashboard', compact(
                'kosts',
                'rooms',
                'tenants',
                'availableRooms',
                'occupiedRooms',
                'occupancyRate',
                'monthlyIncome',
                'monthlyTransactions',
                'pendingPayments',
                'recentPayments'
            ));

        })->name('dashboard');


        // MANAJEMEN KOST
        Route::resource('kosts', KostController::class);


        // MANAJEMEN KAMAR
        Route::resource('kosts.rooms', RoomController::class)
            ->except(['show']);


        // MANAJEMEN PENGHUNI
        Route::resource('tenants', TenantController::class)
            ->except(['show']);


        // PENEMPATAN PENGHUNI

        // Menampilkan daftar penempatan
        Route::get('/assignments', [
            RoomAssignmentController::class,
            'index'
        ])->name('assignments.index');

        // Form tambah penempatan
        Route::get('/assignments/create', [
            RoomAssignmentController::class,
            'create'
        ])->name('assignments.create');

        // Menyimpan penempatan
        Route::post('/assignments', [
            RoomAssignmentController::class,
            'store'
        ])->name('assignments.store');

        // Mengakhiri penempatan
        Route::patch('/assignments/{assignment}/finish', [
            RoomAssignmentController::class,
            'finish'
        ])->name('assignments.finish');


        // MANAJEMEN TAGIHAN
        Route::resource('bills', BillController::class)
            ->only(['index', 'create', 'store', 'destroy']);


        // MANAJEMEN PEMBAYARAN OWNER
        Route::get('/payments', [
            PaymentController::class,
            'index'
        ])->name('payments.index');

        Route::post('/payments/{payment}/verify', [
            PaymentController::class,
            'verify'
        ])->name('payments.verify');

        Route::post('/payments/{payment}/reject', [
            PaymentController::class,
            'reject'
        ])->name('payments.reject');


        // REKAP PEMASUKAN OWNER
        Route::get('/income', [
            PaymentController::class,
            'income'
        ])->name('income.index');

        // EXPORT EXCEL
        Route::get('/income/export-excel', [
            PaymentController::class,
            'exportExcel'
        ])->name('income.export-excel');

        // EXPORT PDF
        Route::get('/income/export-pdf', [
            PaymentController::class,
            'exportPdf'
        ])->name('income.export-pdf');

    });


// TENANT
Route::middleware(['auth', 'verified', 'role:tenant'])
    ->prefix('tenant')
    ->name('tenant.')
    ->group(function () {

        // DASHBOARD TENANT
        Route::get('/dashboard', function () {
            return view('tenant.dashboard');
        })->name('dashboard');


        // TAGIHAN DAN RIWAYAT PEMBAYARAN TENANT
        Route::get('/payments', [
            PaymentController::class,
            'tenantIndex'
        ])->name('payments.index');


        // KIRIM BUKTI PEMBAYARAN
        Route::post('/payments/{bill}', [
            PaymentController::class,
            'store'
        ])->name('payments.store');

    });


// PROFILE
Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});


// AUTHENTICATION
require __DIR__ . '/auth.php';
