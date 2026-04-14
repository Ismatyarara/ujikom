<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ChMessage;
use App\Models\Dokter;
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
        $dokterUserIds = Dokter::verified()->pluck('user_id');
        $unreadDoctorReplies = ChMessage::with('sender')
            ->where('to_id', $user->id)
            ->whereIn('from_id', $dokterUserIds)
            ->where('seen', false)
            ->latest()
            ->get();

        // Tampilkan dashboard
        return view('user.dashboard', [
            'profile' => $profile,
            'unreadDoctorReplyCount' => $unreadDoctorReplies->count(),
            'latestDoctorReplies' => $unreadDoctorReplies->take(5),
        ]);
    }
}
