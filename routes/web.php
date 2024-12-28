<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Login
Route::get("/", fn () => redirect()->route("login"));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('home');
    });

    // Category
    Route::get('/category/data', [CategoryController::class, "data"])->name("category.data");
    Route::resource('/category', CategoryController::class);

    // Product
    Route::get('/product/data', [ProductController::class, "data"])->name("product.data");
    Route::resource('/product', ProductController::class);
    Route::post('/product/delete-selected', [ProductController::class, "deleteSelected"])->name("product.deleteSelected");
    Route::post('/product/print-barcode', [ProductController::class, "printBarcode"])->name("product.printBarcode");
});
