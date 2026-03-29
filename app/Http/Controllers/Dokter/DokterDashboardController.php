<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DokterDashboardController extends Controller
{
    public function index()
    {
        $dokter = Auth::user();

        // Total pasien unik yang pernah chat dengan dokter ini
        $totalPasien = DB::table('ch_messages')
            ->where('to_id', $dokter->id)
            ->distinct('from_id')
            ->count('from_id');

        // Pesan masuk bulan ini
        $konsultasiBulanIni = DB::table('ch_messages')
            ->where('to_id', $dokter->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Pesan masuk hari ini
        $appointmentHariIni = DB::table('ch_messages')
            ->where('to_id', $dokter->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Rating tetap 0 karena Chatify tidak punya fitur rating
        // Ganti dengan query lain jika kamu punya tabel rating sendiri
        $rating = 0;

        return view('dokter.dashboard', compact(
            'totalPasien',
            'konsultasiBulanIni',
            'appointmentHariIni',
            'rating'
        ));
    }
}