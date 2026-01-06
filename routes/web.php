<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes (will be implemented in Phase 5)
Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Auth Routes (Guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    // Authenticated Admin Routes
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Catalog Routes (to be implemented in Phase 3 & 4)
        // Route::prefix('catalog')->name('catalog.')->group(function () {
        //     Route::resource('categories', CategoryController::class);
        //     Route::resource('products', ProductController::class);
        // });

        // Order Routes (to be implemented in Phase 7)
        // Route::prefix('order')->name('order.')->group(function () {
        //     Route::resource('transactions', TransactionController::class);
        // });
    });
});
