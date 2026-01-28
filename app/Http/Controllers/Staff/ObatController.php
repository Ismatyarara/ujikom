<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::latest()->paginate(10);
        return view('staff.obat.index', compact('obat'));
    }

    public function create()
    {
        return view('staff.obat.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_obat'    => 'required',
            'deskripsi'    => 'required',
            'aturan_pakai' => 'required',
            'efek_samping' => 'required',
            'stok'         => 'required|numeric',
            'harga'        => 'required|numeric',
            'satuan'       => 'required',
            'status'       => 'required|boolean',
            'foto'         => 'nullable|image',
        ]);

        $data['kode_obat'] = 'OBT-' . time();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->foto->store('obat', 'public');
        }

        $data['user_id'] = Auth::id();
        Obat::create($data);

        return redirect()->route('staff.obat.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    public function show(Obat $obat)
    {
        return view('staff.obat.show', compact('obat'));
    }

    public function edit(Obat $obat)
    {
        return view('staff.obat.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $data = $request->validate([
            'nama_obat'    => 'required',
            'deskripsi'    => 'required',
            'aturan_pakai' => 'required',
            'efek_samping' => 'required',
            'stok'         => 'required|numeric',
            'harga'        => 'required|numeric',
            'satuan'       => 'required',
            'status'       => 'required|boolean',
            'foto'         => 'nullable|image',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->foto->store('obat', 'public');
        }

        $obat->update($data);

        return redirect()->route('staff.obat.index')
            ->with('success', 'Obat berhasil diupdate');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('staff.obat.index')
            ->with('success', 'Obat berhasil dihapus');
    }
}
