<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Get all users for dashboard
     */
    public function index()
    {
        $users = User::latest()->get();
        return response()->json([
            'success' => true,
            'data'    => $users,
        ]);
    }

    /**
     * Register Process
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
            'status'   => 'aktif',
            'kode_pasien' => User::generateKodePasien(),
        ]);

        try {
            OtpController::sendOtp($user->email);
        } catch (\Throwable $e) {
            report($e);
            $user->delete();

            return response()->json([
                'success' => false,
                'message' => 'OTP gagal dikirim. Periksa konfigurasi email lalu coba lagi.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil. Kode OTP telah dikirim ke email.',
            'requires_otp' => true,
            'email' => $user->email,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ], 201);
    }

    /**
     * Login Process
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        $user  = User::where('email', $request->email)->firstOrFail();

        if (! $user->hasVerifiedEmail()) {
            try {
                OtpController::sendOtp($user->email);
            } catch (\Throwable $e) {
                report($e);

                return response()->json([
                    'success' => false,
                    'message' => 'OTP gagal dikirim. Periksa konfigurasi email lalu coba lagi.',
                ], 500);
            }

            return response()->json([
                'success' => false,
                'message' => 'Email belum diverifikasi. Kode OTP baru telah dikirim.',
                'requires_otp' => true,
                'email' => $user->email,
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'token'   => $token,
            'data'    => $user,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $cacheKey = 'otp_' . $request->email;
        $storedOtp = Cache::get($cacheKey);

        if (! $storedOtp || (string) $storedOtp !== (string) $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP salah atau sudah kadaluarsa.',
            ], 422);
        }

        Cache::forget($cacheKey);

        $user = User::where('email', $request->email)->firstOrFail();

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi OTP berhasil.',
            'token' => $token,
            'data' => $user,
        ]);
    }

    /**
     * Logout Process
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }
}
