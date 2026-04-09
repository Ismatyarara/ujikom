<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;

class UserJadwalController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();

        $jadwals = Jadwal::with(['dokter', 'waktuObat'])
            ->where('user_id', $currentUser->id)
            ->orderByDesc('created_at')
            ->get();

        return view('user.jadwal.index', compact('jadwals', 'currentUser'));
    }

    public function show($id)
    {
        $jadwal = Jadwal::with(['dokter', 'waktuObat'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.jadwal.show', compact('jadwal'));
    }
}
