<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Client\NewsletterEmailController;
use App\Http\Controllers\Core\MailController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::prefix('/login')->group(function () {
    Route::get('/google', [LoginController::class, 'redirectToGoogle'])->name("login.google");
    Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback']);
});
// google provider login
Route::get('register/verificated', [NewsletterEmailController::class,'verificated'])->name("client.register.verification");

Route::get('mail/callback/reset/password', [ResetPasswordController::class,'resetPasswordVerify'])->name("client.reset.password");
Route::post('reset/password', [ResetPasswordController::class,'updatePassword'])->name("client.update.password");
