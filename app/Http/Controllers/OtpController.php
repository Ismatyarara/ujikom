<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function showVerify()
    {
        if (! session('otp_email')) {
            return redirect()->route('login');
        }

        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email = session('otp_email');

        if (! $email) {
            return redirect()->route('login')
                ->withErrors(['otp' => 'Sesi OTP tidak valid. Silakan login ulang.']);
        }

        $cacheKey  = 'otp_' . $email;
        $storedOtp = Cache::get($cacheKey);

        if (! $storedOtp || (string) $storedOtp !== (string) $request->otp) {
            return back()->with('error', 'Kode OTP salah atau sudah kadaluarsa.');
        }

        Cache::forget($cacheKey);

        $user = User::where('email', $email)->firstOrFail();

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        Auth::login($user, remember: true);

        session()->forget(['otp_email', 'show_otp', 'otp_source']);

        // Google & Register → selalu user.dashboard
        // Admin / dokter / staff login biasa lewat form, tidak lewat OTP ini
        return redirect()->route('user.dashboard');
    }

    public function resend(Request $request)
    {
        $email = session('otp_email');

        if (! $email) {
            return redirect()->route('login');
        }

        $rateLimitKey = 'otp_resend_' . $email;
        if (Cache::get($rateLimitKey, 0) >= 3) {
            return back()->with('error', 'Terlalu banyak permintaan. Coba lagi dalam beberapa menit.');
        }

        Cache::increment($rateLimitKey);
        Cache::put($rateLimitKey, Cache::get($rateLimitKey), now()->addMinutes(10));

        static::sendOtp($email);

        return back()->with('success', 'Kode OTP baru telah dikirim.');
    }

    public static function sendOtp(string $email): string
    {
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put('otp_' . $email, $otp, now()->addMinutes(10));

        Mail::send('emails.otp', ['otp' => $otp], function ($m) use ($email) {
            $m->to($email)->subject('Kode Verifikasi HealTack');
        });

        return $otp;
    }
}