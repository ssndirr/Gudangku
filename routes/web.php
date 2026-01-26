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

    // Resource routes admin
    Route::resource('users', UserController::class)->names('users');
    Route::resource('kategoris', KategoriController::class)->names('kategori');
    Route::resource('ruangan', RuanganController::class)->names('ruangan');
    Route::resource('barang', BarangController::class)->names('barang');
    Route::resource('barangmasuk', BarangMasukController::class)->names('barangmasuk');
    Route::resource('barangkeluar', BarangKeluarController::class)->names('barangkeluar');
});


Route::middleware(['auth'])->group(function () {
     // Home index → nama route: home
     Route::get('/home', [HomeController::class, 'index'])->name('home');

     // Home show/detail → nama route: home.show
     Route::get('/home/barang/{id}', [HomeController::class, 'show'])->name('home.show');
});

require __DIR__.'/auth.php';
