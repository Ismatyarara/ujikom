<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\User;

class DokterKonsultasiController extends Controller
{
    /**
     * Menampilkan daftar pasien
     */
    public function index()
    {
        // Ambil semua user dengan role 'users' (pasien)
        $pasiens = User::where('role', 'users')
                      ->orderBy('name')
                      ->paginate(12);
        
        return view('dokter.konsultasi.index', compact('pasiens'));
    }

    /**
     * Redirect ke Chatify dengan pasien tertentu
     */
    public function show($id)
    {
        $pasien = User::findOrFail($id);
        
        
        return redirect('/chat/' . $id);
    }
}