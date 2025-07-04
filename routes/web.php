<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\StatusLaundryController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini semua route aplikasi diatur.
| Semua route admin dibungkus middleware auth & prefix 'admin'.
|
*/

// ⬇️ Redirect root ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});


// ===============================
// ✅ AUTH ROUTES
// ===============================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// (Opsional) Route untuk membuat admin sekali pakai
Route::get('/create-admin', [AuthController::class, 'createAdmin'])->name('create.admin');


// ===============================
// ✅ PUBLIC ROUTE: CEK STATUS LAUNDRY
// ===============================
Route::get('/cek-status', [StatusLaundryController::class, 'index'])->name('cek-status.index');
Route::post('/cek-status', [StatusLaundryController::class, 'cek'])->name('cek-status.cek');


// ===============================
// ✅ PROTECTED ADMIN ROUTES
// ===============================
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // CRUD Pelanggan
    Route::resource('pelanggan', PelangganController::class);

    // CRUD Layanan
    Route::resource('layanan', LayananController::class);

    // CRUD Pesanan
    Route::resource('pesanan', PesananController::class);
    
    // Update status laundry via AJAX
    Route::post('/pesanan/{pesanan}/update-status-laundry', [PesananController::class, 'updateStatusLaundry'])->name('pesanan.update-status-laundry');
    
    // Cetak nota pesanan
    Route::get('/pesanan/{pesanan}/cetak', [PesananController::class, 'cetak'])->name('pesanan.cetak');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

});
