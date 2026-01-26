<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Obat;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDokter = Dokter::count();
        $totalUser = User::where('role', 'user')->count();
        $totalStaff = User::where('role', 'staff')->count();
        $totalObat = Obat::count();
        $stokObat = Obat::sum('stok');
        $obatMenupis = Obat::stokMenupis()->count();

        return view('admin.dashboard', compact(
            'totalDokter',
            'totalUser', 
            'totalStaff',
            'totalObat',
            'stokObat',
            'obatMenupis'
        ));
    }
}