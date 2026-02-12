<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ChMessage;

class DokterDashboardController extends Controller
{
    public function index()
    {
        $dokter = Auth::user(); // ambil user login

        return view('dokter.dashboard', compact('dokter'));
    }
}
