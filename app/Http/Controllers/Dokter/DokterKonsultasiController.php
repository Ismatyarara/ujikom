<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ChMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DokterKonsultasiController extends Controller
{
public function index()
{
    $dokterId = Auth::id();

    $allMessages = ChMessage::where('to_id', $dokterId)
        ->join('users', 'ch_messages.from_id', '=', 'users.id')
        ->select('ch_messages.*', 'users.name as sender_name')
        ->orderBy('ch_messages.created_at', 'desc')
        ->get();

    $recentMessages = $allMessages->groupBy('from_id')
        ->map(function ($messages) {
            return $messages->first();
        })
        ->values();

    $unreadCount = $allMessages->where('seen', 0)->count();

    return view('dokter.konsultasi.index', compact('recentMessages', 'unreadCount'));
}

}