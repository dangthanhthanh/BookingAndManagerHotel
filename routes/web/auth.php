<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\BookingRoomController;
use App\Http\Controllers\Client\NewsletterEmailController;
use App\Http\Controllers\Client\PaymentController;
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

Route::prefix('/payment')
    ->middleware('role:customer')
    ->group(function () {
    Route::get('/checkout', [PaymentController::class,'index'])->name("client.payment.checkout.index");
    Route::post('/vnpay', [PaymentController::class,'vnpay'])->name("client.payment.vnpay");
    Route::post('/destroy', [PaymentController::class,'destroy_order'])->name("client.payment.destroy");
});

Route::prefix('/account')
    ->middleware('role:customer')
    ->group(function () {
    Route::get('/', [AuthController::class,'index'])->name("auth.account.index");
    Route::post('/update', [AuthController::class,'update'])->name("auth.account.update");
    Route::get('/cart', [AuthController::class,'showCart'])->name("auth.account.cart");
    Route::post('/server/cart', [AuthController::class,'CartServer'])->name("auth.account.cart.serve");
    Route::get('/checkout', [AuthController::class,'showCheckout'])->name("auth.account.checkout");
});

Route::prefix('/booking/room')
    ->middleware('role:customer')
    ->group(function () {
    Route::get('/form', [BookingRoomController::class,'index'])->name("client.booking.room.index");
    Route::post('/request/create', [BookingRoomController::class,'createRequest'])->name("client.booking.room.create.request");
    Route::post('/order/create', [BookingRoomController::class,'createOrder'])->name("client.booking.room.create.order");
});

