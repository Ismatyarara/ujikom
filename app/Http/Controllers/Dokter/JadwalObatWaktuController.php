<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalObatWaktu;
use Illuminate\Http\Request;

class JadwalObatController extends Controller
{
    /**
     * Tambah satu waktu minum ke jadwal tertentu.
     * Dipanggil via route: dokter.jadwal.waktu.store (dengan $jadwalId dari route param).
     */
    public function store(Request $request, $jadwalId)
    {
        $request->validate([
            'waktu'   => 'required|array|min:1',
            'waktu.*' => 'required|date_format:H:i',
        ]);

        foreach ($request->waktu as $waktu) {
            // Cegah duplikat
            JadwalObatWaktu::firstOrCreate([
                'jadwal_obat_id' => $jadwalId,
                'waktu'          => $waktu,
            ]);
        }

        return back()->with('success', 'Waktu minum obat berhasil ditambahkan.');
    }

    /**
     * Hapus satu waktu minum obat berdasarkan ID-nya.
     */
    public function destroy($id)
    {
        $waktu = JadwalObatWaktu::findOrFail($id);
        $waktu->delete();

        return back()->with('success', 'Waktu minum obat berhasil dihapus.');
    }
}