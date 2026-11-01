<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Room;
use App\Models\RoomAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RoomAssignmentController extends Controller
{
    /**
     * Menampilkan daftar penempatan penghuni.
     */
    public function index()
    {
        $ownerId = auth()->id();

        $assignments = RoomAssignment::with([
            'tenant.user',
            'room.kost',
        ])
            ->whereHas('tenant', function ($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->whereHas('room.kost', function ($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->latest()
            ->get();

        return view('owner.assignments.index', compact('assignments'));
    }

    /**
     * Menampilkan formulir penempatan penghuni.
     */
    public function create()
    {
        $ownerId = auth()->id();

        $tenants = Tenant::with('user')
            ->where('owner_id', $ownerId)
            ->whereDoesntHave('roomAssignments', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('id', 'desc')
            ->get();

        $rooms = Room::with('kost')
            ->whereHas('kost', function ($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->where('status', 'available')
            ->orderBy('room_number')
            ->get();

        return view('owner.assignments.create', compact(
            'tenants',
            'rooms'
        ));
    }

    /**
     * Menyimpan penempatan penghuni ke kamar.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => [
                'required',
                'integer',
                'exists:tenants,id',
            ],
            'room_id' => [
                'required',
                'integer',
                'exists:rooms,id',
            ],
            'start_date' => [
                'required',
                'date',
            ],
        ], [
            'tenant_id.required' => 'Silakan pilih penghuni.',
            'tenant_id.exists' => 'Data penghuni tidak ditemukan.',
            'room_id.required' => 'Silakan pilih kamar.',
            'room_id.exists' => 'Data kamar tidak ditemukan.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date' => 'Format tanggal tidak valid.',
        ]);

        DB::transaction(function () use ($validated) {

            $ownerId = auth()->id();

            // Memeriksa penghuni milik Owner.
            $tenant = Tenant::where('id', $validated['tenant_id'])
                ->where('owner_id', $ownerId)
                ->lockForUpdate()
                ->first();

            if (!$tenant) {
                throw ValidationException::withMessages([
                    'tenant_id' => 'Penghuni tidak ditemukan atau bukan milik Anda.',
                ]);
            }

            // Memastikan penghuni belum memiliki penempatan aktif.
            $hasActiveAssignment = RoomAssignment::where(
                'tenant_id',
                $tenant->id
            )
                ->where('status', 'active')
                ->exists();

            if ($hasActiveAssignment) {
                throw ValidationException::withMessages([
                    'tenant_id' => 'Penghuni sudah menempati kamar lain.',
                ]);
            }

            // Memeriksa kamar dan kepemilikan kost.
            $room = Room::where('id', $validated['room_id'])
                ->whereHas('kost', function ($query) use ($ownerId) {
                    $query->where('owner_id', $ownerId);
                })
                ->lockForUpdate()
                ->first();

            if (!$room) {
                throw ValidationException::withMessages([
                    'room_id' => 'Kamar tidak ditemukan atau bukan milik Anda.',
                ]);
            }

            // Memastikan kamar masih tersedia.
            if ($room->status !== 'available') {
                throw ValidationException::withMessages([
                    'room_id' => 'Kamar tersebut sudah tidak tersedia.',
                ]);
            }

            // Membuat data penempatan.
            RoomAssignment::create([
                'room_id' => $room->id,
                'tenant_id' => $tenant->id,
                'start_date' => $validated['start_date'],
                'end_date' => null,
                'status' => 'active',
            ]);

            // Mengubah status kamar menjadi occupied.
            $room->update([
                'status' => 'occupied',
            ]);
        });

        return redirect()
            ->route('owner.assignments.index')
            ->with('success', 'Penghuni berhasil ditempatkan ke kamar.');
    }

    /**
     * Mengakhiri penempatan penghuni.
     */
    public function finish(RoomAssignment $assignment)
    {
        $ownerId = auth()->id();

        $assignment->load(['tenant', 'room.kost']);

        // Memastikan penempatan milik Owner yang login.
        abort_unless(
            $assignment->tenant
            && $assignment->room
            && $assignment->room->kost
            && $assignment->tenant->owner_id == $ownerId
            && $assignment->room->kost->owner_id == $ownerId,
            403
        );

        if ($assignment->status !== 'active') {
            return redirect()
                ->route('owner.assignments.index')
                ->with('error', 'Penempatan ini sudah tidak aktif.');
        }

        DB::transaction(function () use ($assignment) {

            $lockedAssignment = RoomAssignment::where(
                'id',
                $assignment->id
            )
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedAssignment->status !== 'active') {
                throw ValidationException::withMessages([
                    'assignment' => 'Penempatan ini sudah tidak aktif.',
                ]);
            }

            $room = Room::where(
                'id',
                $lockedAssignment->room_id
            )
                ->lockForUpdate()
                ->firstOrFail();

            // Mengakhiri penempatan.
            $lockedAssignment->update([
                'status' => 'completed',
                'end_date' => now()->toDateString(),
            ]);

            // Membebaskan kamar.
            $room->update([
                'status' => 'available',
            ]);
        });

        return redirect()
            ->route('owner.assignments.index')
            ->with('success', 'Penempatan berhasil diakhiri. Kamar sekarang tersedia.');
    }
}
