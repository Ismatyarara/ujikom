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
        // Cari spesialisasi berdasarkan ID
        $spesialisasi = Spesialisasi::findOrFail($id);
        
        // Ambil semua dokter dengan spesialisasi_id yang sesuai
        $dokters = Dokter::where('spesialisasi_id', $id)
                         ->with(['spesialisasi', 'pengguna'])
                         ->get();
        
        // Debug jika tidak ada dokter
        // \Log::info('Spesialisasi ID: ' . $id);
        // \Log::info('Jumlah Dokter: ' . $dokters->count());
        
        return view('user.konsultasi.show', compact('spesialisasi', 'dokters'));
    }
}