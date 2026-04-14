<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminAnalisisController;
use App\Http\Controllers\Api\MobilePreviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin', function () {
    return response()->json([
        'message' => 'Halo Admin'
    ]);
});

Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin/analisis', [AdminAnalisisController::class, 'index']);

Route::middleware(['auth:sanctum', 'role:dokter'])->get('/dokter', function () {
    return response()->json([
        'message' => 'Halo Dokter'
    ]);
});

Route::middleware(['auth:sanctum', 'role:staff'])->get('/staff', function () {
    return response()->json([
        'message' => 'Halo Staff'
    ]);
});
 Route::middleware(['auth:sanctum', 'role:user'])->get('/user-area', function () {
    return response()->json([
        'message' => 'Halo User'
    ]);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');
Route::get('/mobile/home', [MobilePreviewController::class, 'home']);


use App\Http\Controllers\Api\CatatanMedisApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('catatan', CatatanMedisApiController::class);
});

Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
use App\Http\Controllers\Api\JadwalApiController;
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/jadwal',      [JadwalApiController::class, 'index']);
    Route::get('/jadwal/{id}', [JadwalApiController::class, 'show']);
});


use App\Http\Controllers\Api\TokoApiController;

Route::middleware('auth:sanctum')->group(function () {
    // ...route lainnya

    Route::prefix('obat')->group(function () {
        Route::get('/', [TokoApiController::class, 'index']);
        Route::get('/{id}', [TokoApiController::class, 'show']);
    });

    Route::prefix('toko')->group(function () {
        Route::post('/beli', [TokoApiController::class, 'beli']);
        Route::get('/riwayat', [TokoApiController::class, 'riwayat']);
        Route::get('/riwayat/{id}', [TokoApiController::class, 'detailTransaksi']);
    });
});