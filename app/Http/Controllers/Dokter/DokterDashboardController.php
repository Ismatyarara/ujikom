<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterDashboardController extends Controller
{
    public function index()
    {
        $dokter = Auth::user();

        // Tampilkan dashboard
        return view('dokter.dashboard', compact('dokter'));
    }
}