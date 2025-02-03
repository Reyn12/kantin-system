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
        
        // Add more admin routes here
    });
});