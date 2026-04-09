<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\CatatanMedis;
use App\Models\Dokter;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DokterDashboardController extends Controller
{
    public function index()
    {
        $dokterUser = Auth::user();
        $dokter = Dokter::with('spesialisasi')
            ->where('user_id', $dokterUser->id)
            ->first();

        // Total pasien unik yang pernah chat dengan dokter ini
        $totalPasien = DB::table('ch_messages')
            ->where('to_id', $dokterUser->id)
            ->distinct('from_id')
            ->count('from_id');

        // Pesan masuk bulan ini
        $konsultasiBulanIni = DB::table('ch_messages')
            ->where('to_id', $dokterUser->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Pesan masuk hari ini
        $konsultasiHariIni = DB::table('ch_messages')
            ->where('to_id', $dokterUser->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $catatanMedisDibuat = $dokter
            ? CatatanMedis::where('dokter_id', $dokter->id)->count()
            : 0;

        $jadwalAktif = $dokter
            ? Jadwal::where('dokter_id', $dokter->id)
                ->where(function ($query) {
                    $query->whereNull('status')
                        ->orWhere('status', 'aktif');
                })
                ->count()
            : 0;

        $jadwalHariIni = $dokter
            ? Jadwal::with('user')
                ->where('dokter_id', $dokter->id)
                ->whereDate('tanggal_mulai', '<=', Carbon::today())
                ->whereDate('tanggal_selesai', '>=', Carbon::today())
                ->latest()
                ->limit(5)
                ->get()
            : collect();

        $catatanTerbaru = $dokter
            ? CatatanMedis::with('user')
                ->where('dokter_id', $dokter->id)
                ->latest('tanggal_catatan')
                ->limit(5)
                ->get()
            : collect();

        return view('dokter.dashboard', compact(
            'totalPasien',
            'konsultasiBulanIni',
            'konsultasiHariIni',
            'catatanMedisDibuat',
            'jadwalAktif',
            'jadwalHariIni',
            'catatanTerbaru',
            'dokterUser',
            'dokter'
        ));
    }
}
