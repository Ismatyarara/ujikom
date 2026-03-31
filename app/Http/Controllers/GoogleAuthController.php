<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login Google gagal. Coba lagi.');
        }

        // Cari atau buat user — role selalu 'user' untuk login Google
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'              => $googleUser->getName(),
                'google_id'         => $googleUser->getId(),
                'avatar'            => $googleUser->getAvatar(),
                'email_verified_at' => now(),
                'password'          => bcrypt(Str::random(24)),
                'role'              => 'user',
            ]
        );

        // Simpan session & kirim OTP
        session([
            'otp_email'  => $user->email,
            'otp_source' => 'google',
        ]);
        OtpController::sendOtp($user->email);

        return redirect()->route('otp.verify');
    }
}