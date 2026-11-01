<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Memastikan kost adalah milik owner yang sedang login.
     */
    private function checkOwner(Kost $kost): void
    {
        abort_unless(
            (int) $kost->owner_id === (int) auth()->id(),
            403,
            'Anda tidak memiliki akses ke properti ini.'
        );
    }

    /**
     * Menampilkan seluruh kamar dalam satu kost.
     */
    public function index(Kost $kost)
    {
        $this->checkOwner($kost);

        $rooms = $kost->rooms()->latest()->get();

        return view('owner.rooms.index', compact('kost', 'rooms'));
    }

    /**
     * Menampilkan form tambah kamar.
     */
    public function create(Kost $kost)
    {
        $this->checkOwner($kost);

        return view('owner.rooms.create', compact('kost'));
    }

    /**
     * Menyimpan kamar baru.
     */
    public function store(Request $request, Kost $kost)
    {
        $this->checkOwner($kost);

        $validated = $request->validate([
            'room_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms', 'room_number')
                    ->where('kost_id', $kost->id),
            ],
            'monthly_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'status' => [
                'required',
                Rule::in(['available', 'occupied']),
            ],
        ], [
            'room_number.required' => 'Nomor kamar wajib diisi.',
            'room_number.unique' => 'Nomor kamar sudah digunakan pada kost ini.',
            'monthly_price.required' => 'Harga sewa wajib diisi.',
            'monthly_price.numeric' => 'Harga sewa harus berupa angka.',
            'monthly_price.min' => 'Harga sewa tidak boleh negatif.',
            'status.required' => 'Status kamar wajib dipilih.',
        ]);

        $kost->rooms()->create($validated);

        return redirect()
            ->route('owner.kosts.rooms.index', $kost->id)
            ->with('success', 'Kamar berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit kamar.
     */
    public function edit(Kost $kost, Room $room)
    {
        $this->checkOwner($kost);

        $room = $kost->rooms()->findOrFail($room->id);

        return view('owner.rooms.edit', compact('kost', 'room'));
    }

    /**
     * Memperbarui data kamar.
     */
    public function update(Request $request, Kost $kost, Room $room)
    {
        $this->checkOwner($kost);

        $room = $kost->rooms()->findOrFail($room->id);

        $validated = $request->validate([
            'room_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms', 'room_number')
                    ->where('kost_id', $kost->id)
                    ->ignore($room->id),
            ],
            'monthly_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'status' => [
                'required',
                Rule::in(['available', 'occupied']),
            ],
        ], [
            'room_number.required' => 'Nomor kamar wajib diisi.',
            'room_number.unique' => 'Nomor kamar sudah digunakan pada kost ini.',
            'monthly_price.required' => 'Harga sewa wajib diisi.',
            'monthly_price.numeric' => 'Harga sewa harus berupa angka.',
            'monthly_price.min' => 'Harga sewa tidak boleh negatif.',
            'status.required' => 'Status kamar wajib dipilih.',
        ]);

        $room->update($validated);

        return redirect()
            ->route('owner.kosts.rooms.index', $kost->id)
            ->with('success', 'Data kamar berhasil diperbarui.');
    }

    /**
     * Menghapus kamar.
     */
    public function destroy(Kost $kost, Room $room)
    {
        $this->checkOwner($kost);

        $room = $kost->rooms()->findOrFail($room->id);

        if ($room->roomAssignments()->exists()) {
            return redirect()
                ->route('owner.kosts.rooms.index', $kost->id)
                ->with('error', 'Kamar tidak dapat dihapus karena sudah memiliki riwayat penyewaan.');
        }

        $room->delete();

        return redirect()
            ->route('owner.kosts.rooms.index', $kost->id)
            ->with('success', 'Kamar berhasil dihapus.');
    }
}
