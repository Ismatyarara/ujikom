<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::paginate(10);
        return view('admin.obat.index', compact('obat'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

 public function store(Request $request)
{
    $validated = $request->validate([
        'nama_obat'    => 'required|string|max:255',
        'deskripsi'    => 'required|string',
        'aturan_pakai' => 'required|string',
        'efek_samping' => 'required|string',
        'stok'         => 'required|integer|min:0',
        'harga'        => 'required|integer|min:0',
        'satuan'       => 'required|string|max:50',
        'status'       => 'required|boolean',
        'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // kode otomatis
    $validated['kode_obat'] = 'OBT-' . str_pad(Obat::count() + 1, 4, '0', STR_PAD_LEFT);

    // upload foto
    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('obat', 'public');
    }

    Obat::create($validated);

    return redirect()->route('admin.obat.index')
        ->with('success', 'Obat berhasil ditambahkan');
}


    public function show(Obat $obat)
    {
        return view('admin.obat.show', compact('obat'));
    }

    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }

     public function update(Request $request, Obat $obat)
{
    $validated = $request->validate([
        'nama_obat'    => 'required|string|max:255',
        'deskripsi'    => 'required|string',
        'aturan_pakai' => 'required|string',
        'efek_samping' => 'required|string',
        'stok'         => 'required|integer|min:0',
        'harga'        => 'required|integer|min:0',
        'satuan'       => 'required|string|max:50',
        'status'       => 'required|boolean',
        'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('foto')) {
        if ($obat->foto) {
            Storage::disk('public')->delete($obat->foto);
        }
        $validated['foto'] = $request->file('foto')->store('obat', 'public');
    }

    $obat->update($validated);

    return redirect()->route('admin.obat.index')
        ->with('success', 'Data obat berhasil diupdate');
}


    public function destroy(Obat $obat)
    {
        if ($obat->foto) Storage::disk('public')->delete($obat->foto);
        $obat->delete();

        return redirect()->route('admin.obat.index')->with('success', 'Obat berhasil dihapus');
    }
}