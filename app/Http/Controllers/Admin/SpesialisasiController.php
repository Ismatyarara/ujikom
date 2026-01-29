<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spesialisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:spesialisasi,name',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')
                ->store('spesialisasi', 'public');
        }

        Spesialisasi::create($data);

        return redirect()->route('admin.spesialisasi.index')
            ->with('success', 'Spesialisasi berhasil ditambahkan');
    }

    public function show(Spesialisasi $spesialisasi)
    {
        $spesialisasi->loadCount('dokter')
                     ->load('dokter.pengguna');

        return view('admin.spesialisasi.show', compact('spesialisasi'));
    }

    public function edit(Spesialisasi $spesialisasi)
    {
        return view('admin.spesialisasi.edit', compact('spesialisasi'));
    }

     public function update(Request $request, Spesialisasi $spesialisasi)
{
    $data = $request->validate([
        'name' => 'required|string|max:255|unique:spesialisasi,name,' . $spesialisasi->id,
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('foto')) {

        // hapus foto lama
        if ($spesialisasi->foto) {
            Storage::disk('public')->delete($spesialisasi->foto);
        }

        // simpan foto baru
        $data['foto'] = $request->file('foto')
                                 ->store('spesialisasi', 'public');
    }

    $spesialisasi->update($data);

    return redirect()->route('admin.spesialisasi.index')
        ->with('success', 'Spesialisasi berhasil diupdate');
}


    public function destroy(Spesialisasi $spesialisasi)
    {
        if ($spesialisasi->dokter()->count() > 0) {
            return back()->with('error', 'Spesialisasi masih digunakan dokter');
        }

        if ($spesialisasi->foto) {
            Storage::disk('public')->delete($spesialisasi->foto);
        }

        $spesialisasi->delete();

        return back()->with('success', 'Spesialisasi berhasil dihapus');
    }
}
