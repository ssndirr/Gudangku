<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RuanganApiController;
use App\Http\Controllers\Api\KategoriApiController;
use App\Http\Controllers\Api\BarangApiController;
use App\Http\Controllers\Api\BarangMasukApiController;
use App\Http\Controllers\Api\BarangKeluarApiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/kategori', [KategoriApiController::class, 'index']);
    Route::post('/kategori', [KategoriApiController::class, 'store']);
    Route::get('/kategori/{id}', [KategoriApiController::class, 'show']);
    Route::put('/kategori/{id}', [KategoriApiController::class, 'update']);
    Route::delete('/kategori/{id}', [KategoriApiController::class, 'destroy']);

    Route::get('/ruangan', [RuanganApiController::class, 'index']);
    Route::post('/ruangan', [RuanganApiController::class, 'store']);
    Route::get('/ruangan/{id}', [RuanganApiController::class, 'show']);
    Route::put('/ruangan/{id}', [RuanganApiController::class, 'update']);
    Route::delete('/ruangan/{id}', [RuanganApiController::class, 'destroy']);

    Route::get('/barang', [BarangApiController::class, 'index']);
    Route::post('/barang', [BarangApiController::class, 'store']);
    Route::get('/barang/{id}', [BarangApiController::class, 'show']);
    Route::put('/barang/{id}', [BarangApiController::class, 'update']);
    Route::delete('/barang/{id}', [BarangApiController::class, 'destroy']);

    Route::get('/barang-masuk', [BarangMasukApiController::class, 'index']);
    Route::post('/barang-masuk', [BarangMasukApiController::class, 'store']);
    Route::get('/barang-masuk/{id}', [BarangMasukApiController::class, 'show']);
    Route::put('/barang-masuk/{id}', [BarangMasukApiController::class, 'update']);
    Route::delete('/barang-masuk/{id}', [BarangMasukApiController::class, 'destroy']);

    Route::get('/barang-keluar', [BarangKeluarApiController::class, 'index']);
    Route::post('/barang-keluar', [BarangKeluarApiController::class, 'store']);
    Route::get('/barang-keluar/{id}', [BarangKeluarApiController::class, 'show']);
    Route::put('/barang-keluar/{id}', [BarangKeluarApiController::class, 'update']);
    Route::delete('/barang-keluar/{id}', [BarangKeluarApiController::class, 'destroy']);
});