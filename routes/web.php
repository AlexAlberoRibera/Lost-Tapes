<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;

Route::get('/', function () {
    return view('welcome');
});

// OAuth2 Google — redirige al frontend con token en query string tras el callback
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php';
