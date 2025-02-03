<?php

use Illuminate\Support\Facades\Route;

// Admin Use
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout'); // Tambah ini
    
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('products', [AdminProductController::class, 'index'])->name('admin.products');
        Route::post('products', [AdminProductController::class, 'store']); // Tambah ini
        Route::get('products/{id}/edit', [AdminProductController::class, 'edit']);
        Route::put('products/{id}', [AdminProductController::class, 'update']);
        Route::delete('products/{id}', [AdminProductController::class, 'destroy']);
        Route::post('products/{id}/status', [AdminProductController::class, 'updateStatus']);
        Route::post('products/{id}/stock', [AdminProductController::class, 'updateStock']);
        
        // Add more admin routes here
    });
});