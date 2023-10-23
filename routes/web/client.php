<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\NewsletterEmailController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\BlogController as ClientBlogController;
use App\Http\Controllers\Client\ContactController as ClientContactController;
use App\Http\Controllers\Client\EventController;
use App\Http\Controllers\Client\FoodController as ClientFoodController;
use App\Http\Controllers\Client\RoomController as ClientRoomController;
use App\Http\Controllers\Client\ServiceController as ClientServiceController;

Route::prefix('/client')
    ->group(function () {

    Route::prefix('/room')->group(function () {
        Route::get('/post/{keyword?}', [ClientRoomController::class,'index'])->name("client.room.index"); //khoi chay cho category
        Route::get('/detail/{slug}', [ClientRoomController::class,'detail'])->name("client.room.detail");
    });

    Route::prefix('/service')->group(function () {
        Route::get('/post/{category?}/{keyword?}', [ClientServiceController::class,'index'])->name("client.service.index");
        Route::get('/detail/{slug}', [ClientServiceController::class,'detail'])->name("client.service.detail");
    });

    Route::prefix('/event')->group(function () {
        Route::get('/post/{category?}/{keyword?}', [EventController::class,'index'])->name("client.event.index");
        Route::get('/detail/{slug}', [EventController::class,'detail'])->name("client.event.detail");
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
});
