<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KabupatenKotaController;
use App\Http\Controllers\KecamatanController;

Route::get('/api/provinsi', [ProvinsiController::class, 'index']);
Route::get('/peta', function() {
    return view('peta');
});
Route::get('/api/kabupaten-kota', [KabupatenKotaController::class, 'index']);
Route::get('/api/kecamatan/{kode}', [KecamatanController::class, 'byKabupaten']);
Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

