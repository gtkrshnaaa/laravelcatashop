<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Catalog\CategoryController;
use App\Http\Controllers\Admin\Catalog\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{product:slug}', [PublicProductController::class, 'show'])->name('products.show');

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

        // Catalog Routes
        Route::prefix('catalog')->name('catalog.')->group(function () {
            Route::resource('categories', CategoryController::class);
            Route::resource('products', ProductController::class);
        });

        // Order Routes (to be implemented in Phase 7)
        // Route::prefix('order')->name('order.')->group(function () {
        //     Route::resource('transactions', TransactionController::class);
        // });
    });
});
