<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ManufacturerController;

// Products
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show')->whereNumber('id');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::put('/{id}', [ProductController::class, 'update'])->name('products.update')->whereNumber('id');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->whereNumber('id');

    // Reviews
    Route::get('/{id}/reviews', [ProductController::class, 'reviews'])->name('products.reviews.index')->whereNumber('id');
    Route::post('/{id}/reviews', [ProductController::class, 'addReview'])->name('products.reviews.add')->whereNumber('id');

    // Bulk Buy and Merge Buy Products
    Route::prefix('buy')->group(function () {
        Route::post('/bulk', [ProductController::class, 'createBulkBuyProduct'])->name('products.bulkBuy.create');
        Route::get('/bulk', [ProductController::class, 'listBulkBuyProducts'])->name('products.bulkBuy.index');
        Route::post('/merge', [ProductController::class, 'createMergeBuyProduct'])->name('products.mergeBuy.create');
        Route::get('/merge', [ProductController::class, 'listMergeBuyProducts'])->name('products.mergeBuy.index');
        Route::put('/merge/{id}', [ProductController::class, 'updateMergeBuySettings'])->name('products.mergeBuy.update')->whereNumber('id');
    });
});

Route::post('/manufacturers/{manufacturerId}/products/{productId}/participants', [ManufacturerController::class, 'addParticipant']);
Route::get('/manufacturers/{manufacturerId}/products/{productId}/participants', [ManufacturerController::class, 'viewParticipants']);


// Manufacturers
Route::prefix('manufacturers')->group(function () {
    Route::get('/', [ManufacturerController::class, 'index'])->name('manufacturers.index');
    Route::get('/{id}', [ManufacturerController::class, 'show'])->name('manufacturers.show')->whereNumber('id');
    Route::post('/', [ManufacturerController::class, 'store'])->name('manufacturers.store');
    Route::put('/{id}', [ManufacturerController::class, 'update'])->name('manufacturers.update')->whereNumber('id');
    Route::delete('/{id}', [ManufacturerController::class, 'destroy'])->name('manufacturers.destroy')->whereNumber('id');

    // Search
    Route::get('/search', [ManufacturerController::class, 'search'])->name('manufacturers.search');

    // Filter Manufacturer Products by Purchase Type
    Route::get('/{id}/products', [ManufacturerController::class, 'filterProducts'])->name('manufacturers.products.filter')->whereNumber('id');
});

// Orders
Route::prefix('orders')->group(function () {
    Route::post('/', [OrderController::class, 'placeOrder'])->name('orders.place');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show')->whereNumber('id');
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
});

// Test Route
Route::get('/test', function () {
    return 'Routes are working!';
});
