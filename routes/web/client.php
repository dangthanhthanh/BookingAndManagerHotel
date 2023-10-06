<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\NewsletterEmailController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\BlogController as ClientBlogController;
use App\Http\Controllers\Client\BookingRoomController as ClientBookingRoomController;
use App\Http\Controllers\Client\ContactController as ClientContactController;
use App\Http\Controllers\Client\FoodController as ClientFoodController;
use App\Http\Controllers\Client\PaymentController as ClientPaymentController;
use App\Http\Controllers\Client\RoomController as ClientRoomController;
use App\Http\Controllers\Client\ServiceController as ClientServiceController;

Route::prefix('/client')->group(function () {
    // khach thao tac tren loai phong chu khong thao tac truc tiep tren phong cua minh,
    // giam xung dot khi dat phong (khi nao khach dong y voi gia demo cho loai phong thi xet id cua khach cho phong do ,tao don hang,... tra ve ket qua thuc te thong qua mail va web app)
    // tang kha nang phu hop
    // kich thich nhu cau can tu van cua khac hang 
    Route::prefix('/room')->group(function () {
        Route::get('/post/{keyword?}', [ClientRoomController::class,'index'])->name("client.room.index"); //khoi chay cho category
        Route::get('/detail/{slug}', [ClientRoomController::class,'detail'])->name("client.room.detail");
    });
    Route::prefix('/service')->group(function () {
        Route::get('/post/{category?}/{keyword?}', [ClientServiceController::class,'index'])->name("client.service.index");
        Route::get('/detail/{slug}', [ClientServiceController::class,'detail'])->name("client.service.detail");
    });
    Route::prefix('/food')->group(function () {
        Route::get('/post/{category?}/{keyword?}', [ClientFoodController::class,'index'])->name("client.food.index");
        Route::get('/detail/{slug}', [ClientFoodController::class,'detail'])->name("client.food.detail");
    });
    Route::prefix('/blog')->group(function () {
        Route::get('/post/{category?}/{keyword?}', [ClientBlogController::class,'index'])->name("client.blog.index");
        Route::get('/detail/{slug}', [ClientBlogController::class,'detail'])->name("client.blog.detail");
    });
    Route::get('/about', [AboutController::class,'index'])->name("client.about.index");
    Route::prefix('/contact')->group(function () {
        Route::get('/', [ClientContactController::class,'index'])->name("client.contact.index");
        Route::post('/store', [ClientContactController::class,'create'])->name("client.contact.store");
        Route::get('/verificated', [ClientContactController::class,'verificated'])->name("client.contact.verification");
    });
    Route::prefix('/newsemail')->group(function () {
        Route::post('/store', [NewsletterEmailController::class,'create'])->name("client.newsemail.store");
        Route::get('/verificated', [NewsletterEmailController::class,'verificated'])->name("client.newsemail.verification");
    });
    Route::prefix('/booking/room')->group(function () {
        Route::get('/form', [ClientBookingRoomController::class,'index'])->name("client.booking.room.index");
        Route::post('/request/create', [ClientBookingRoomController::class,'createRequest'])->name("client.booking.room.create.request");
        Route::post('/order/create', [ClientBookingRoomController::class,'createOrder'])->name("client.booking.room.create.order");
    });
    Route::prefix('/payment')->group(function () {
        Route::get('/checkout', [ClientPaymentController::class,'index'])->name("client.payment.checkout.index");
        Route::post('/vnpay', [ClientPaymentController::class,'vnpay'])->name("client.payment.vnpay");
        Route::post('/destroy', [ClientPaymentController::class,'destroy_order'])->name("client.payment.destroy");
    });
    
    Route::get('/account', [AuthController::class,'index'])->name("auth.account.index");
    Route::post('/account/update', [AuthController::class,'update'])->name("auth.account.update");
    Route::get('/account/booking', [AuthController::class,'showCart'])->name("auth.account.cart");
});
