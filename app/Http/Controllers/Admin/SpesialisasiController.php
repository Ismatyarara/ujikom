<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spesialisasi;
use Illuminate\Http\Request;

class SpesialisasiController extends Controller
{
    public function index()
    {
        $spesialisasis = Spesialisasi::withCount('dokter')->paginate(10);
        return view('admin.spesialisasi.index', compact('spesialisasis'));
    }

    public function create()
    {
        return view('admin.spesialisasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:spesialisasi,name', // Ubah 'nama' jadi 'name'
        ]);

        Spesialisasi::create($validated);

        return redirect()->route('admin.spesialisasi.index')
            ->with('success', 'Spesialisasi berhasil ditambahkan');
    }

    public function show(Spesialisasi $spesialisasi)
    {
        $spesialisasi->loadCount('dokter');
        $spesialisasi->load('dokter.pengguna');
        return view('admin.spesialisasi.show', compact('spesialisasi'));
    }

    public function edit(Spesialisasi $spesialisasi)
    {
        return view('admin.spesialisasi.edit', compact('spesialisasi'));
    }

    public function update(Request $request, Spesialisasi $spesialisasi)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:spesialisasi,name,' . $spesialisasi->id, // Ubah 'nama' jadi 'name'
        ]);

        $spesialisasi->update($validated);

        return redirect()->route('admin.spesialisasi.index')
            ->with('success', 'Spesialisasi berhasil diupdate');
    }

    public function destroy(Spesialisasi $spesialisasi)
    {
        // Cek apakah spesialisasi masih digunakan oleh dokter
        if ($spesialisasi->dokter()->count() > 0) {
            return redirect()->route('admin.spesialisasi.index')
                ->with('error', 'Spesialisasi tidak dapat dihapus karena masih digunakan oleh dokter');
        }

        $spesialisasi->delete();

        return redirect()->route('admin.spesialisasi.index')
            ->with('success', 'Spesialisasi berhasil dihapus');
    }
}