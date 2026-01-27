<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Konsultasi;
use App\Models\RekamMedis;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $dokter = Auth::user();
        
        // Statistik
        $stats = [
            'total_pasien' => User::where('role', 'user')->count(),
            'konsultasi_hari_ini' => 0, // Sesuaikan dengan model Konsultasi Anda
            'konsultasi_menunggu' => 0, // Konsultasi yang belum ditangani
            'rekam_medis_bulan_ini' => 0, // Sesuaikan dengan model RekamMedis Anda
        ];
        
        // Jadwal hari ini (sesuaikan dengan model Jadwal Anda)
        $jadwalHariIni = []; // Ambil dari database
        
        // Konsultasi terbaru
        $konsultasiTerbaru = []; // Ambil dari database
        
        // Aktivitas terbaru
        $aktivitasTerbaru = []; // Kombinasi dari berbagai aktivitas
        
        return view('dokter.dashboard', compact(
            'dokter',
            'stats',
            'jadwalHariIni',
            'konsultasiTerbaru',
            'aktivitasTerbaru'
        ));
    }
}