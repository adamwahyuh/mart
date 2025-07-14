<?php

use App\Models\Movement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BatchesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\MovementsController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Rute yang membutuhkan login
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('/products', ProductController::class);

    Route::resource('/vendors', VendorController::class);

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    Route::get('/batches/select-product', [BatchesController::class, 'selectProduct'])->name('batches.select-product');
    Route::resource('/batches', BatchesController::class);
    
    Route::get('/movements/select-batch', [MovementsController::class, 'selectBatch'])->name('movements.select-batch');
    Route::resource('/movements', MovementsController::class)->except('destroy', 'update', 'edit');

    // Test dos
    Route::get('/dos', [DosController::class, 'index'])->name('dos.index');
    Route::delete('/dos', [DosController::class, 'destroyAll'])->name('dos.destroyAll');

    // Kasir (Orders)
    Route::prefix('orders')->middleware('auth')->group(function () {
        Route::get('create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('add-to-cart/{product}', [OrderController::class, 'addToCart'])->name('orders.addToCart');
        Route::delete('cart-item/{id}', [OrderController::class, 'removeCartItem'])->name('orders.removeCartItem');
        Route::post('place-order', [OrderController::class, 'placeOrder'])->name('orders.placeOrder');
        Route::get('cart', [OrderController::class, 'getCart'])->name('orders.getCart');
    });

    Route::resource('/orders', OrderController::class)->only(['index', 'show', 'destroy']);
    // Only edit status 
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
    ->name('orders.updateStatus');
});
