<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Cek apakah user sudah punya profile
        if (!$user->profile) {
            return redirect()->route('user.profile.create')
                ->with('warning', 'Silakan lengkapi profile Anda terlebih dahulu untuk mengakses dashboard.');
        }

        // Ambil data profile
        $profile = $user->profile;

        // Tampilkan dashboard
        return view('user.dashboard', compact('profile'));
    }
}