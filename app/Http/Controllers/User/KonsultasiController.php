<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Spesialisasi;

class KonsultasiController extends Controller
{
    public function index()
    {
        // ambil dokter dari tabel dokter
        $dokter = Dokter::with('pengguna')->get();
        $spesialisasis = Spesialisasi::paginate(6);

       return view('user.konsultasi.index', compact('dokter', 'spesialisasis'));
    }

    public function show($id)
    {
        $spesialis = Spesialisasi::findOrFail($id);

        $dokter = Dokter::where('id_spesialisasi', $id)
                        ->with('pengguna')
                        ->get();

        return view('user.konsultasi.show', compact('dokter', 'spesialis'));
    }
}
