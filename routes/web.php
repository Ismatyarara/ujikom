<?php

use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\UserController;
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
    Route::get('obat', [ObatController::class, 'index'])->name('obat.index');
    Route::get('obat/pembelian', [ObatController::class, 'pembelian'])->name('obat.pembelian');
    Route::get('obat/{id}', [ObatController::class, 'show'])->name('obat.show');
    Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
    Route::resource('spesialisasi', App\Http\Controllers\Admin\SpesialisasiController::class); 
});

// ==================== DOKTER ROUTES ====================
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Dokter\DashboardController::class, 'index'])->name('dashboard');
    // Route::resource('jadwal', App\Http\Controllers\Dokter\JadwalController::class);
    // Route::resource('konsultasi', App\Http\Controllers\Dokter\KonsultasiController::class);
    // Route::resource('chat', App\Http\Controllers\Dokter\ChatController::class);
    // Route::resource('rekam-medis', App\Http\Controllers\Dokter\RekamMedisController::class);
    // Route::resource('obat', App\Http\Controllers\Dokter\ObatController::class)->only(['index', 'show']);
    // Route::resource('laporan', App\Http\Controllers\Dokter\LaporanController::class)->only(['index']);
    // Route::get('/profile', [App\Http\Controllers\Dokter\ProfileController::class, 'index'])->name('profile');
    // Route::put('/profile', [App\Http\Controllers\Dokter\ProfileController::class, 'update'])->name('profile.update');
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
     Route::resource('obat', App\Http\Controllers\Staff\ObatController::class);
});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    // Route::resource('profile', App\Http\Controllers\User\ProfileController::class)->only(['index', 'edit', 'update']);
    // Route::resource('konsultasi', App\Http\Controllers\User\KonsultasiController::class);
    // Route::resource('chat', App\Http\Controllers\User\ChatController::class);
    // Route::resource('catatan-medis', App\Http\Controllers\User\CatatanMedisController::class)->only(['index', 'show']);
    // Route::resource('obat', App\Http\Controllers\User\ObatController::class)->only(['index', 'show']);
    // Route::resource('jadwal-obat', App\Http\Controllers\User\JadwalObatController::class);
});