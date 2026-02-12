<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\CatatanMedis;
use App\Models\User;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanMedisController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $user = Auth::user();
        
        $dokter = Dokter::where('user_id', $user->id)->first();

        $catatan = CatatanMedis::where('dokter_id', $dokter->id)
            ->latest('tanggal_catatan')
            ->get();

        return view('dokter.catatan.index', compact('catatan'));
    }

    // ================= CREATE =================
    public function create()
    {
        $pasien = User::where('role', 'user')->orderBy('name')->get();
        
        return view('dokter.catatan.create', compact('pasien'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'keluhan' => 'required',
            'diagnosa' => 'required',
            'tanggal_catatan' => 'required|date',
        ]);

        $dokter = Dokter::where('user_id', Auth::id())->first();

        CatatanMedis::create([
            'user_id' => $request->user_id,
            'dokter_id' => $dokter->id,
            'keluhan' => $request->keluhan,
            'diagnosa' => $request->diagnosa,
            'deskripsi' => $request->deskripsi,
            'tanggal_catatan' => $request->tanggal_catatan,
        ]);

        return redirect()->route('dokter.catatan.index')
            ->with('success', 'Catatan berhasil ditambahkan');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $catatan = CatatanMedis::findOrFail($id);
        $pasien = User::where('role', 'user')->orderBy('name')->get();
        
        return view('dokter.catatan.edit', compact('catatan', 'pasien'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'keluhan' => 'required',
            'diagnosa' => 'required',
            'tanggal_catatan' => 'required|date',
        ]);

        $catatan = CatatanMedis::findOrFail($id);
        
        $dokter = Dokter::where('user_id', Auth::id())->first();

        $catatan->update([
            'user_id' => $request->user_id,
            'dokter_id' => $dokter->id,
            'keluhan' => $request->keluhan,
            'diagnosa' => $request->diagnosa,
            'deskripsi' => $request->deskripsi,
            'tanggal_catatan' => $request->tanggal_catatan,
        ]);

        return redirect()->route('dokter.catatan.index')
            ->with('success', 'Catatan berhasil diperbarui');
    }

    // ================= DESTROY =================
    public function destroy($id)
    {
        $catatan = CatatanMedis::findOrFail($id);
        $catatan->delete();

        return redirect()->route('dokter.catatan.index')
            ->with('success', 'Catatan berhasil dihapus');
    }
}