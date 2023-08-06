<?php

use Illuminate\Support\Facades\Route;

    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // // room
    // Route::resource('room', RoomController::class);
    // Route::get('room/setStatus/{id}/{status?}', [RoomController::class, 'setStatus'])->name('room.setStatus');
    // Route::get('room/restore/{id}', [RoomController::class, 'restore'])->name('room.restore');
    // Route::post('room/forceDelete', [RoomController::class, 'forceDelete'])->name('room.forceDelete');
    // // roomCategory
    // Route::resource('roomtype', RoomTypeController::class);
    // Route::get('roomtype/restore/{id}', [RoomTypeController::class, 'restore'])->name('roomtype.restore');
    // Route::post('roomtype/forceDelete', [RoomTypeController::class, 'forceDelete'])->name('roomtype.forceDelete');
    // // blog
    // Route::resource('blog', BlogController::class);
    // Route::get('blog/setStatus/{id}/{status?}', [BlogController::class, 'setStatus'])->name('blog.setStatus');
    // Route::get('blog/restore/{id}', [BlogController::class, 'restore'])->name('blog.restore');
    // Route::post('blog/forceDelete', [BlogController::class, 'forceDelete'])->name('blog.forceDelete');
    // // customer staff manager account
    // Route::resource('user', UserController::class);
    // Route::get('user/setStatus/{id}/{status?}', [UserController::class, 'setStatus'])->name('user.setStatus');
    // Route::get('user/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
    // Route::post('user/forceDelete', [UserController::class, 'forceDelete'])->name('user.forceDelete');

    // Route::resource('staff', StaffController::class);
    // Route::get('staff/setStatus/{id}/{status?}', [StaffController::class, 'setStatus'])->name('staff.setStatus');
    // Route::get('staff/restore/{id}', [StaffController::class, 'restore'])->name('staff.restore');
    // Route::post('staff/forceDelete', [StaffController::class, 'forceDelete'])->name('staff.forceDelete');
    // // food
    // Route::resource('food', FoodController::class);
    // Route::get('food/setStatus/{id}/{status?}', [FoodController::class, 'setStatus'])->name('food.setStatus');
    // Route::get('food/restore/{id}', [FoodController::class, 'restore'])->name('food.restore');
    // Route::get('book/food', [FoodController::class, 'booking'])->name('food.booking');
    // Route::post('food/forceDelete', [StaffController::class, 'forceDelete'])->name('food.forceDelete');
    // // service
    // Route::resource('service', ServiceController::class);
    // Route::get('service/setStatus/{id}/{status?}', [ServiceController::class, 'setStatus'])->name('service.setStatus');
    // Route::get('service/restore/{id}', [ServiceController::class, 'restore'])->name('service.restore');
    // Route::get('book/service', [ServiceController::class, 'booking'])->name('service.booking');
    // Route::post('service/forceDelete', [ServiceController::class, 'forceDelete'])->name('service.forceDelete');
    // // payment
    // Route::resource('payment', PaymentController::class);
    // Route::get('payment/restore/{id}', [PaymentController::class, 'restore'])->name('payment.restore');
    // Route::get('payment/payment/{payment_id}', [PaymentController::class, 'payment'])->name('payment.payment');
    // Route::post('payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    // Route::post('payment/paymentOrder', [PaymentController::class, 'orderPayment'])->name('payment.order');
    // Route::post('payment/forceDelete', [PaymentController::class, 'forceDelete'])->name('payment.forceDelete');
    // // bookingroom
    // Route::resource('booking', BookingController::class);
    // Route::get('booking/restore/{id}', [BookingController::class, 'restore'])->name('booking.restore');
    // Route::get('booking/getCustomer/{phone?}',[BookingController::class,'getCustomer'])->name('booking.getCustomer');
    // Route::post('booking/registerCustomer',[BookingController::class,'registerCustomer'])->name('booking.registerCustomer');
    // Route::post('booking/forceDelete', [BookingController::class, 'forceDelete'])->name('booking.forceDelete');
    // // bookingservice
    // Route::resource('bookingservice', BookingServiceController::class);
    // Route::get('bookingservice/restore/{id}', [BookingServiceController::class, 'restore'])->name('bookingservice.restore');
    // Route::get('bookingservice/getCustomer/{phone?}',[BookingServiceController::class,'getCustomer'])->name('bookingservice.getCustomer');
    // Route::post('bookingservice/registerCustomer',[BookingServiceController::class,'registerCustomer'])->name('bookingservice.registerCustomer');
    // Route::post('bookingservice/forceDelete', [BookingServiceController::class, 'forceDelete'])->name('bookingservice.forceDelete');
    // // bookingfood
    // Route::resource('bookingfood', BookingFoodController::class);
    // Route::get('bookingfood/restore/{id}', [BookingFoodController::class, 'restore'])->name('bookingfood.restore');
    // Route::get('bookingfood/getCustomer/{phone?}',[BookingFoodController::class,'getCustomer'])->name('bookingfood.getCustomer');
    // Route::post('bookingfood/registerCustomer',[BookingFoodController::class,'registerCustomer'])->name('bookingfood.registerCustomer');
    // Route::post('bookingfood/forceDelete', [BookingFoodController::class, 'forceDelete'])->name('bookingfood.forceDelete');
    // // room cell
    // Route::resource('bookCalender',BookCalenderController::class);
    // // historypayment
    // Route::get('history/payment',[OrderPaymentController::class , 'index'])->name('history.payment');
    // //manager request customer
    // Route::get('order/request',[OrderRequestController::class , 'index'])->name('order.request');