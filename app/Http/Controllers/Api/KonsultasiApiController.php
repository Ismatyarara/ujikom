<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Spesialisasi;
use App\Models\Dokter;
use App\Models\ChMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiApiController extends Controller
{
    // GET /api/spesialisasi → list semua spesialisasi
    public function spesialisasi()
    {
        $data = Spesialisasi::all();
        return response()->json(['success' => true, 'data' => $data]);
    }

    // GET /api/spesialisasi/{id}/dokter → list dokter by spesialisasi
    public function dokterBySpesialisasi($id)
    {
        $spesialisasi = Spesialisasi::find($id);
        if (!$spesialisasi) {
            return response()->json(['success' => false, 'message' => 'Spesialisasi tidak ditemukan'], 404);
        }

        $dokters = Dokter::verified()
            ->where('spesialisasi_id', $id)
            ->with(['spesialisasi', 'pengguna'])
            ->get();

        return response()->json([
            'success'      => true,
            'spesialisasi' => $spesialisasi,
            'data'         => $dokters
        ]);
    }

    // GET /api/konsultasi/pesan/{dokterId} → riwayat chat dengan dokter
    public function riwayatChat($dokterId)
    {
        $userId = Auth::id();

        $messages = ChMessage::where(function ($q) use ($userId, $dokterId) {
                $q->where('from_id', $userId)->where('to_id', $dokterId);
            })
            ->orWhere(function ($q) use ($userId, $dokterId) {
                $q->where('from_id', $dokterId)->where('to_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['success' => true, 'data' => $messages]);
    }

    // POST /api/konsultasi/pesan → kirim pesan ke dokter
    public function kirimPesan(Request $request)
    {
        $request->validate([
            'to_id'   => 'required|exists:users,id',
            'body'    => 'required|string',
        ]);

        $message = ChMessage::create([
            'from_id' => Auth::id(),
            'to_id'   => $request->to_id,
            'body'    => $request->body,
            'seen'    => 0,
        ]);

        return response()->json(['success' => true, 'data' => $message], 201);
    }
}
