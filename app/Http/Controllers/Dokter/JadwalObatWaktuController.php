<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\JadwalObatWaktu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalObatController extends Controller
{
     public function store(Request $request)
    {
        $request->validate([
            'jadwal_obat_id' => 'required|exists:jadwal,id',
            'waktu' => 'required',
        ]);

        JadwalObatWaktu::create([
            'jadwal_obat_id' => $request->jadwal_obat_id,
            'waktu' => $request->waktu,
        ]);

        return back()->with('success', 'Jam minum berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $waktu = JadwalObatWaktu::findOrFail($id);
        $waktu->delete();

        return back()->with('success', 'Jam minum berhasil dihapus');
    }
}