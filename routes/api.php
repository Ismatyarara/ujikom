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

