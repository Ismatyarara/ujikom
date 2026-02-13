<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Obat;
use App\Models\JadwalObatWaktu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
  public function create()
{

    $dokters = Dokter::orderBy('nama')->get();

    $pasien = User::where('role', 'user')->orderBy('name')->get();

    $obats = Obat::orderBy('nama_obat')->get();

    return view('dokter.jadwal.create', compact('dokters', 'pasien','obats'));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'dokter_id' => 'required|exists:dokter,id',
            'nama_obat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $jadwal = Jadwal::create($validated);

        // Redirect ke halaman atur waktu
        return redirect()->route('dokter.jadwal.waktu.create', $jadwal->id)
            ->with('success', 'Jadwal berhasil dibuat! Silakan atur waktu minum obat.');
    }

    // Halaman untuk atur waktu
    public function createWaktu($jadwalId)
    {
        $jadwal = Jadwal::with('user', 'dokter')->findOrFail($jadwalId);
        return view('dokter.jadwal.waktu', compact('jadwal'));
    }

    // Simpan waktu-waktu obat
    public function storeWaktu(Request $request, $jadwalId)
    {
        $request->validate([
            'waktu' => 'required|array|min:1',
            'waktu.*' => 'required|date_format:H:i',
        ]);

        $jadwal = Jadwal::findOrFail($jadwalId);

        // Hapus waktu lama (kalau ada)
        $jadwal->waktuObat()->delete();

        // Simpan waktu baru
        foreach ($request->waktu as $waktu) {
            JadwalObatWaktu::create([
                'jadwal_obat_id' => $jadwal->id,
                'waktu' => $waktu,
            ]);
        }

        return redirect()->route('dokter.jadwal.index')
            ->with('success', 'Waktu minum obat berhasil disimpan!');
    }
}
