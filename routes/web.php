<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Catalog\CategoryController;
use App\Http\Controllers\Admin\Catalog\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Order\TransactionController;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\CheckoutController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\InvoiceController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{product:slug}', [PublicProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// Invoice Routes
Route::get('/invoice/{transaction}', [InvoiceController::class, 'show'])->name('invoice.show');

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

        // Order Routes
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
            Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
            Route::patch('/transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
        });
    });
});
