<?php

use App\Http\Controllers\OAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('auth/google', [OAuthController::class, 'redirect'])->name('auth.google');
Route::get('auth/google/callback', [OAuthController::class, 'googleCallback']);
