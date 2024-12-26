<?php

use App\Http\Controllers\CategoryController;
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
});
