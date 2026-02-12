<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CatatanMedis;
use Illuminate\Support\Facades\Auth;

class CatatanMedisController extends Controller
{
    /**
     * Menampilkan list catatan medis user yang login
     */
    public function index()
{
    $catatan = CatatanMedis::where('user_id', Auth::id())  // ← Filter by pasien yang login
        ->with(['dokter.pengguna'])
        ->orderBy('tanggal_catatan', 'desc')
        ->get();
    
    return view('user.catatan.index', compact('catatan'));
}
    /**
     * Menampilkan detail catatan medis
     */
    public function show($id)
    {
        $catatan = CatatanMedis::where('user_id', Auth::id())
            ->with(['dokter.pengguna'])
            ->findOrFail($id);
        
        return view('user.catatan.show', compact('catatan'));
    }
}