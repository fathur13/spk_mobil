<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\SPKController;
use App\Http\Controllers\RekomendasiController;

// 🏠 Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// 🚗 Manajemen Data Mobil (CRUD)
Route::resource('mobils', MobilController::class);

// 🔍 Pencarian Mobil (Di luar grup agar URL tetap simple)
Route::get('/search', [MobilController::class, 'search'])->name('mobils.search');

// 📊 Normalisasi SPK
Route::get('/normalisasi', [SPKController::class, 'normalisasi'])->name('normalisasi');

// 🔥 Rekomendasi Mobil
Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
