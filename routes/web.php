<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Rute yang membutuhkan login
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    });

    Route::resource('/products', ProductController::class);

    Route::resource('/vendors', VendorController::class);

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/dos', [DosController::class, 'index'])->name('dos.index');
Route::delete('/dos', [DosController::class, 'destroyAll'])->name('dos.destroyAll');