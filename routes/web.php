<?php

use Illuminate\Support\Facades\Route;

// Admin Use
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // Products Management Routes
        Route::prefix('products')->group(function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('admin.products');
            Route::post('/', [AdminProductController::class, 'store']);
            Route::get('/{id}/edit', [AdminProductController::class, 'edit']);
            Route::put('/{id}', [AdminProductController::class, 'update']);
            Route::delete('/{id}', [AdminProductController::class, 'destroy']);
            Route::post('/{id}/status', [AdminProductController::class, 'updateStatus']);
            Route::post('/{id}/stock', [AdminProductController::class, 'updateStock']);
            Route::get('/download/pdf', [AdminProductController::class, 'downloadPDF'])->name('admin.products.download.pdf');
            Route::get('/download/excel', [AdminProductController::class, 'downloadExcel'])->name('admin.products.download.excel');
        });
        
        // Categories Management Routes
        Route::prefix('categories')->group(function () {
            Route::get('/', [AdminCategoryController::class, 'index'])->name('admin.categories');
            Route::post('/', [AdminCategoryController::class, 'store']);
            Route::get('/{id}/edit', [AdminCategoryController::class, 'edit']);
            Route::put('/{id}', [AdminCategoryController::class, 'update']);
            Route::delete('/{id}', [AdminCategoryController::class, 'destroy']);
        });

        // Orders Management Routes
        Route::prefix('orders')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('admin.orders');
            Route::post('/', [AdminOrderController::class, 'store']);
            Route::get('/{id}/edit', [AdminOrderController::class, 'edit']);
            Route::put('/{id}', [AdminOrderController::class, 'update']);
            Route::delete('/{id}', [AdminOrderController::class, 'destroy']);
        });
    });
});