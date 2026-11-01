<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    /**
     * Menampilkan seluruh penghuni milik Owner.
     */
    public function index()
    {
        $tenants = Tenant::with([
            'user',
            'roomAssignments.room.kost'
        ])
            ->where('owner_id', auth()->id())
            ->latest()
            ->get();

        return view('owner.tenants.index', compact('tenants'));
    }

    /**
     * Menampilkan formulir tambah penghuni.
     */
    public function create()
    {
        return view('owner.tenants.create');
    }

    /**
     * Membuat akun sekaligus data penghuni.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'phone' => [
                'required',
                'string',
                'max:255',
            ],
            'emergency_contact' => [
                'nullable',
                'string',
                'max:255',
            ],
        ], [
            'name.required' => 'Nama penghuni wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'phone.required' => 'Nomor telepon wajib diisi.',
        ]);

        DB::transaction(function () use ($validated) {

            // Membuat akun pengguna dengan role tenant.
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'tenant',
            ]);

            // Membuat data penghuni dan menghubungkannya
            // dengan akun serta Owner yang sedang login.
            Tenant::create([
                'user_id' => $user->id,
                'owner_id' => auth()->id(),
                'phone' => $validated['phone'],
                'emergency_contact' =>
                    $validated['emergency_contact'] ?? null,
            ]);
        });

        return redirect()
            ->route('owner.tenants.index')
            ->with('success', 'Penghuni dan akun tenant berhasil dibuat.');
    }

    /**
     * Menampilkan formulir edit penghuni.
     */
    public function edit(Tenant $tenant)
    {
        abort_unless(
            $tenant->owner_id === auth()->id(),
            403
        );

        $tenant->load('user');

        return view('owner.tenants.edit', compact('tenant'));
    }

    /**
     * Memperbarui data penghuni.
     */
    public function update(Request $request, Tenant $tenant)
    {
        abort_unless(
            $tenant->owner_id === auth()->id(),
            403
        );

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($tenant->user_id),
            ],
            'phone' => [
                'required',
                'string',
                'max:255',
            ],
            'emergency_contact' => [
                'nullable',
                'string',
                'max:255',
            ],
        ], [
            'name.required' => 'Nama penghuni wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'phone.required' => 'Nomor telepon wajib diisi.',
        ]);

        DB::transaction(function () use ($validated, $tenant) {

            $tenant->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $tenant->update([
                'phone' => $validated['phone'],
                'emergency_contact' =>
                    $validated['emergency_contact'] ?? null,
            ]);
        });

        return redirect()
            ->route('owner.tenants.index')
            ->with('success', 'Data penghuni berhasil diperbarui.');
    }

    /**
     * Menghapus data penghuni.
     */
    public function destroy(Tenant $tenant)
    {
        abort_unless(
            $tenant->owner_id === auth()->id(),
            403
        );

        if ($tenant->roomAssignments()->exists()) {
            return redirect()
                ->route('owner.tenants.index')
                ->with(
                    'error',
                    'Penghuni tidak dapat dihapus karena memiliki riwayat penempatan kamar.'
                );
        }

        $tenant->delete();

        return redirect()
            ->route('owner.tenants.index')
            ->with('success', 'Data penghuni berhasil dihapus.');
    }
}
