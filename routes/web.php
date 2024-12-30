<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

// Login
Route::get("/", fn () => redirect()->route("login"));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    // Route::get('/dashboard/data', [DashboardController::class, "data"])->name("category.data");
    Route::resource('/dashboard', DashboardController::class);

    // Category
    Route::get('/category/data', [CategoryController::class, "data"])->name("category.data");
    Route::resource('/category', CategoryController::class);

    // Product
    Route::get('/product/data', [ProductController::class, "data"])->name("product.data");
    Route::resource('/product', ProductController::class);
    Route::post('/product/delete-selected', [ProductController::class, "deleteSelected"])->name("product.deleteSelected");
    Route::post('/product/print-barcode', [ProductController::class, "printBarcode"])->name("product.printBarcode");

    // Member
    Route::get('/member/data', [MemberController::class, "data"])->name("member.data");
    Route::resource('/member', MemberController::class);
    Route::post('/member/delete-selected', [MemberController::class, "deleteSelected"])->name("member.deleteSelected");
    Route::post('/member/print-member', [MemberController::class, "printMember"])->name("member.printMember");

    // Supplier
    Route::get('/supplier/data', [SupplierController::class, "data"])->name("supplier.data");
    Route::resource('/supplier', SupplierController::class);
    Route::post('/supplier/delete-selected', [SupplierController::class, "deleteSelected"])->name("supplier.deleteSelected");
    Route::post('/supplier/print-supplier', [SupplierController::class, "printSupplier"])->name("member.printSupplier");
});
