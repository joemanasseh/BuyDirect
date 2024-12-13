<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\MergeBuyController; // Include MergeBuyController if needed

// Products
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show')->where('id', '[0-9]+');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::put('/{id}', [ProductController::class, 'update'])->name('products.update')->where('id', '[0-9]+');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->where('id', '[0-9]+');

    // Reviews
    Route::get('/{id}/reviews', [ProductController::class, 'reviews'])->name('products.reviews.index');
    Route::post('/{id}/reviews', [ProductController::class, 'addReview'])->name('products.reviews.add');

    // Bulk Buy Products
    Route::post('/bulk-buy', [ProductController::class, 'createBulkBuyProduct'])->name('products.bulkBuy.create');
    Route::get('/bulk-buy', [ProductController::class, 'listBulkBuyProducts'])->name('products.bulkBuy.index');
    
    // Merge Buy Products
    Route::post('/merge-buy', [ProductController::class, 'createMergeBuyProduct'])->name('products.mergeBuy.create');
    Route::get('/merge-buy', [ProductController::class, 'listMergeBuyProducts'])->name('products.mergeBuy.index');
    Route::put('/merge-buy/{id}', [ProductController::class, 'updateMergeBuySettings'])->name('products.mergeBuy.update')->where('id', '[0-9]+');
});

// Manufacturers
Route::prefix('manufacturers')->group(function () {
    Route::get('/', [ManufacturerController::class, 'index'])->name('manufacturers.index');
    Route::get('/{id}', [ManufacturerController::class, 'show'])->name('manufacturers.show')->where('id', '[0-9]+');
    Route::post('/', [ManufacturerController::class, 'store'])->name('manufacturers.store');
    Route::put('/{id}', [ManufacturerController::class, 'update'])->name('manufacturers.update')->where('id', '[0-9]+');
    Route::delete('/{id}', [ManufacturerController::class, 'destroy'])->name('manufacturers.destroy')->where('id', '[0-9]+');

    // Search
    Route::get('/search', [ManufacturerController::class, 'search'])->name('manufacturers.search');

    // Filter Manufacturer Products by Purchase Type
    Route::get('/{id}/products', [ManufacturerController::class, 'filterProducts'])->name('manufacturers.products.filter')->where('id', '[0-9]+');
});

// Orders
Route::prefix('orders')->group(function () {
    Route::post('/', [OrderController::class, 'placeOrder'])->name('orders.place');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show')->where('id', '[0-9]+');
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
});

// Test Route
Route::get('/test', function () {
    return 'Routes are working!';
});
