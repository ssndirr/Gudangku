<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', RoleMiddleware::class.':admin'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('kategori', KategoriController::class); 
    Route::resource('ruangan', RuanganController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('barangmasuk', BarangMasukController::class);
    Route::resource('barangkeluar', BarangKeluarController::class);
});

Route::middleware(['auth'])->group(function () {
    // Home routes for all authenticated users
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/barang/{barang}', [HomeController::class, 'show'])->name('home.show');
    
    // Order routes for staff only
    Route::get('/home/order', [HomeController::class, 'order'])->name('home.order');
    Route::post('/home/order/masuk', [HomeController::class, 'storeBarangMasuk'])->name('home.order.masuk');
    Route::post('/home/order/keluar', [HomeController::class, 'storeBarangKeluar'])->name('home.order.keluar');
});

require __DIR__.'/auth.php';