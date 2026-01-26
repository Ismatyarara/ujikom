<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total obat
        $totalObat = Obat::count();
        
        // Obat dengan stok rendah (< 10)
        $obatStokRendah = Obat::where('stok', '<', 10)->count();
        
        // Total barang masuk bulan ini
        $barangMasukBulanIni = BarangMasuk::whereMonth('tanggal_masuk', date('m'))
            ->whereYear('tanggal_masuk', date('Y'))
            ->sum('jumlah');
        
        // Total barang keluar bulan ini
        $barangKeluarBulanIni = BarangKeluar::whereMonth('tanggal_keluar', date('m'))
            ->whereYear('tanggal_keluar', date('Y'))
            ->sum('jumlah');
        
        // Obat terlaris (top 5)
        $obatTerlaris = BarangKeluar::select('id_obat', DB::raw('SUM(jumlah) as total_terjual'))
            ->with('obat')
            ->groupBy('id_obat')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();
        
        // Transaksi terakhir (barang keluar)
        $transaksiTerakhir = BarangKeluar::with('obat')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Data untuk chart - barang masuk vs keluar per bulan (6 bulan terakhir)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('M Y');
            
            $masuk = BarangMasuk::whereMonth('tanggal_masuk', $date->month)
                ->whereYear('tanggal_masuk', $date->year)
                ->sum('jumlah');
            
            $keluar = BarangKeluar::whereMonth('tanggal_keluar', $date->month)
                ->whereYear('tanggal_keluar', $date->year)
                ->sum('jumlah');
            
            $chartData[] = [
                'month' => $month,
                'masuk' => $masuk,
                'keluar' => $keluar
            ];
        }
        
        return view('staff.dashboard', compact(
            'totalObat',
            'obatStokRendah',
            'barangMasukBulanIni',
            'barangKeluarBulanIni',
            'obatTerlaris',
            'transaksiTerakhir',
            'chartData'
        ));
    }
}
