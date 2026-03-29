<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;

class JadwalApiController extends Controller
{
    // GET /api/jadwal → list semua jadwal milik user
    public function index()
    {
        $jadwals = Jadwal::with(['dokter', 'waktuObat'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $jadwals
        ]);
    }

    // GET /api/jadwal/{id} → detail 1 jadwal
    public function show($id)
    {
        $jadwal = Jadwal::with(['dokter', 'waktuObat'])
            ->where('user_id', Auth::id())
            ->find($id);

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $jadwal
        ]);
    }
}