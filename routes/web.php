<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Tambahkan baris ini untuk route login, register, dll
Auth::routes();

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('dokter', App\Http\Controllers\Admin\DokterController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('obat', App\Http\Controllers\Admin\ObatController::class);
    Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
    Route::resource('spesialisasi', App\Http\Controllers\Admin\SpesialisasiController::class); 
});

// Dokter Routes
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    //Route::get('/dashboard', [App\Http\Controllers\Dokter\DashboardController::class, 'index'])->name('dashboard');
    
//     // Jadwal Praktik
//     Route::get('/jadwal', [App\Http\Controllers\Dokter\JadwalController::class, 'index'])->name('jadwal.index');
    
//     // Data Pasien
//     Route::resource('pasien', App\Http\Controllers\Dokter\PasienController::class)->only(['index', 'show']);
    
//     // Konsultasi
//     Route::resource('konsultasi', App\Http\Controllers\Dokter\KonsultasiController::class);
    
//     // Catatan Medis
//     Route::resource('catatan-medis', App\Http\Controllers\Dokter\CatatanMedisController::class);
    
//     // Data Obat (read-only)
//     Route::resource('obat', App\Http\Controllers\Dokter\ObatController::class)->only(['index', 'show']);
    
//     // Chat
//     Route::resource('chat', App\Http\Controllers\Dokter\ChatController::class)->only(['index', 'show']);
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
   Route::get('/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');
    
    // Penjualan Obat (Lihat Penjualan Obat)
    Route::resource('penjualan', App\Http\Controllers\Staff\PenjualanController::class)->only(['index', 'create', 'store', 'show']);
    
    // Data Pembelian Obat (Read-only - Lihat Data Pembelian Obat)
    Route::resource('pembelian', App\Http\Controllers\Staff\PembelianController::class)->only(['index', 'show']);
    
    // Barang Masuk (Manage Barang Masuk)
    Route::resource('barang-masuk', App\Http\Controllers\Staff\BarangMasukController::class);
    
    // Barang Keluar (Manage Barang Keluar)
    Route::resource('barang-keluar', App\Http\Controllers\Staff\BarangKeluarController::class);
});

// User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');
});