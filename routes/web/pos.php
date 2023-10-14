<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pos\CustomerController as PosCustomerController;
use App\Http\Controllers\Pos\EventController;
use App\Http\Controllers\Pos\FoodController as PosFoodController;
use App\Http\Controllers\Pos\PaymentController as PosPaymentController;
use App\Http\Controllers\Pos\RoomController as PosRoomController;
use App\Http\Controllers\Pos\ServiceController as PosServiceController;

Route::prefix('/pos')
    ->middleware('cashier')
    ->group(function () {
    Route::get('/food', [PosFoodController::class,'index'])->name("pos.food.index");
    Route::get('/room', [PosRoomController::class,'index'])->name("pos.room.index");
    Route::get('/service', [PosServiceController::class,'index'])->name("pos.service.index");
    Route::get('/event', [EventController::class,'index'])->name("pos.event.index");
    Route::get('/customer', [PosCustomerController::class,'index'])->name("pos.customer.index");

    Route::prefix('/payment')->group(function () {
        Route::get('/', [PosPaymentController::class,'index'])->name("pos.payment.index");
        Route::get('/server/delete', [PosPaymentController::class,'deletedAllServer'])->name("pos.server.delete");
        Route::post('/get/customer',[PosPaymentController::class,'getCustomer'])->name('pos.payment.get.customer');
        Route::post('/create/customer',[PosPaymentController::class,'registerCustomer'])->name('pos.payment.create.customer');
        Route::post('/update/customer/{slug}',[PosPaymentController::class,'updateCustomer'])->name('pos.payment.update.customer');
        Route::post('/create',[PosPaymentController::class,'registerCustomer'])->name('pos.payment.create');
        Route::post('/processLocalStorage',[PosPaymentController::class,'processLocalStorage'])->name('pos.payment.processLocalStorage');

        Route::post('/cash',[PosPaymentController::class,'cashPayment'])->name('pos.payment.cashPayment');
        Route::post('/cash/handle/{slug}',[PosPaymentController::class,'cashHandlePayment'])->name('pos.payment.cashHandle.create');
        // Route::post('/Vnpay',[PosPaymentController::class,'vnpayPayment'])->name('pos.payment.vnpayPayment');
    });
});