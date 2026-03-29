<?php

use App\Http\Controllers\Api\AuthController;
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



use App\Http\Controllers\Api\JadwalApiController;
use App\Http\Controllers\Api\KonsultasiApiController;

Route::middleware(['auth:sanctum'])->group(function () {
    // Jadwal Obat
    Route::get('/jadwal',      [JadwalApiController::class, 'index']);
    Route::get('/jadwal/{id}', [JadwalApiController::class, 'show']);

    // Konsultasi
    Route::get('/spesialisasi',                        [KonsultasiApiController::class, 'spesialisasi']);
    Route::get('/spesialisasi/{id}/dokter',            [KonsultasiApiController::class, 'dokterBySpesialisasi']);
    Route::get('/konsultasi/pesan/{dokterId}',         [KonsultasiApiController::class, 'riwayatChat']);
    Route::post('/konsultasi/pesan',                   [KonsultasiApiController::class, 'kirimPesan']);
});

