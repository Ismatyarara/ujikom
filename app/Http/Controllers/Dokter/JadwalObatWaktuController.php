<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalObatWaktu;
use Illuminate\Http\Request;

class JadwalObatWaktuController extends Controller
{
   public function store(Request $request, $jadwalId)
{
    $request->validate([
        'waktu'   => 'required|array|min:1',
        'waktu.*' => 'required|date_format:H:i',
    ]);

    foreach ($request->waktu as $waktu) {
        JadwalObatWaktu::firstOrCreate([
            'jadwal_obat_id' => $jadwalId,
            'waktu'          => $waktu,
        ]);
    }

    // Redirect ke show detail jadwal
    return redirect()
        ->route('dokter.jadwal.show', $jadwalId)
        ->with('success', 'Waktu minum obat berhasil ditambahkan.');
}

    public function destroy($id)
    {
        $waktu = JadwalObatWaktu::findOrFail($id);
        $waktu->delete();

        return back()->with('success', 'Waktu berhasil dihapus');
    }
}