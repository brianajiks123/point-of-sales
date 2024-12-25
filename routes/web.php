<?php

use Illuminate\Support\Facades\Route;

// Login
Route::get("/", fn () => redirect()->route("login"));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    });
});
