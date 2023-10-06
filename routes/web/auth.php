<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\NewsletterEmailController;
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]);

Route::prefix('/login')->group(function () {
    Route::get('/google', [LoginController::class, 'redirectToGoogle'])->name("login.google");
    Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback']);
});
// google provider login
Route::get('register/verificated', [NewsletterEmailController::class,'verificated'])->name("client.register.verification");
