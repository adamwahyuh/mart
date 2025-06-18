<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


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

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::get('/dos', [DosController::class, 'index'])->name('dos.index');
Route::delete('/dos', [DosController::class, 'destroyAll'])->name('dos.destroyAll');