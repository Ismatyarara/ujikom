<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ================= CONTROLLERS =================
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\KonsultasiController;
use App\Http\Controllers\Dokter\DokterDashboardController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('dokter', App\Http\Controllers\Admin\DokterController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);

        Route::get('obat/pembelian', [ObatController::class, 'pembelian'])
            ->name('obat.pembelian');

        Route::resource('obat', ObatController::class);
        Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
        Route::resource('spesialisasi', App\Http\Controllers\Admin\SpesialisasiController::class);
    });

/*
|--------------------------------------------------------------------------
| DOKTER
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Dokter\DokterKonsultasiController;


// Route Dokter
Route::middleware(['auth'])->prefix('dokter')->name('dokter.')->group(function () {
   
        Route::get('/dashboard', [DokterDashboardController::class, 'index'])
            ->name('dashboard');

    
    // Konsultasi
    Route::get('/konsultasi', [DokterKonsultasiController::class, 'index'])->name('konsultasi.index');
    Route::get('/konsultasi/{user}', [DokterKonsultasiController::class, 'show'])->name('konsultasi.show');
});

/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        Route::get('/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('penjualan', App\Http\Controllers\Staff\PenjualanController::class)
            ->only(['index', 'create', 'store', 'show']);

        Route::resource('pembelian', App\Http\Controllers\Staff\PembelianController::class)
            ->only(['index', 'show']);

        Route::resource('barang-masuk', App\Http\Controllers\Staff\BarangMasukController::class);
        Route::resource('barang-keluar', App\Http\Controllers\Staff\BarangKeluarController::class);
        Route::resource('obat', App\Http\Controllers\Staff\ObatController::class);
    });

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Profile
        Route::prefix('profile')
            ->name('profile.')
            ->group(function () {
                Route::get('/', [ProfileController::class, 'show'])->name('show');
                Route::get('/create', [ProfileController::class, 'create'])->name('create');
                Route::post('/', [ProfileController::class, 'store'])->name('store');
                Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
                Route::put('/', [ProfileController::class, 'update'])->name('update');
                Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
            });

     

            Route::resource('konsultasi',KonsultasiController::class);
    });

    
