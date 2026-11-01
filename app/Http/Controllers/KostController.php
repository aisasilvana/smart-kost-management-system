<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;

class KostController extends Controller
{
    public function index()
    {
        $kosts = Kost::with('rooms')
            ->where('owner_id', auth()->id())
            ->latest()
            ->get();

        return view('owner.kosts.index', compact('kosts'));
    }

    public function create()
    {
        return view('owner.kosts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $validated['owner_id'] = auth()->id();

        Kost::create($validated);

        return redirect()
            ->route('owner.kosts.index')
            ->with('success', 'Properti kost berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $kost = $this->findOwnerKost($id);

        return view('owner.kosts.edit', compact('kost'));
    }

    public function update(Request $request, string $id)
    {
        $kost = $this->findOwnerKost($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $kost->update($validated);

        return redirect()
            ->route('owner.kosts.index')
            ->with('success', 'Data properti berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kost = $this->findOwnerKost($id);

        if ($kost->rooms()->exists()) {
            return redirect()
                ->route('owner.kosts.index')
                ->with('error', 'Kost tidak dapat dihapus karena masih memiliki data kamar.');
        }

        $kost->delete();

        return redirect()
            ->route('owner.kosts.index')
            ->with('success', 'Properti kost berhasil dihapus.');
    }

    private function findOwnerKost(string $id): Kost
    {
        return Kost::where('owner_id', auth()->id())
            ->findOrFail($id);
    }
}
