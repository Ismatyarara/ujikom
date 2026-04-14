<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Spesialisasi;
use App\Models\Dokter;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    /**
     * Menampilkan daftar spesialisasi
     */
    public function index()
    {
        $spesialisasis = Spesialisasi::paginate(12);
        return view('user.konsultasi.index', compact('spesialisasis'));
    }

    /**
     * Menampilkan daftar dokter berdasarkan spesialisasi
     * Parameter bisa berupa: $id, $spesialisasi_id, atau $spesialisasi
     */
    public function show($id)
    {
        $spesialisasi = Spesialisasi::findOrFail($id);

        $dokters = Dokter::verified()
            ->where('spesialisasi_id', $id)
            ->with(['spesialisasi', 'pengguna'])
            ->get();

        return view('user.konsultasi.show', compact('spesialisasi', 'dokters'));
    }
}
