<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Dashboard\dashboardController;


Route::middleware('auth')->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::get('kategori/{id}/delete', [KategoriController::class, 'destroy']);

    Route::resource('buku', BukuController::class);
    Route::get('buku/{id}/delete', [BukuController::class, 'destroy']);
    
    Route::get('dashboard',[dashboardController::class,'index']);
    Route::get('/',[dashboardController::class,'index']);
});

require __DIR__.'/auth.php';
