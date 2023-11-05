<?php

use App\Http\Controllers\Cache\BlogController;
use App\Http\Controllers\Cache\OrderController;
use App\Http\Controllers\Cache\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/cache/user', [UserController::class,'get'])->name("cache.user.get");
Route::get('/cache/user/delete', [UserController::class,'delete'])->name("cache.user.delete");

Route::get('/cache/order', [OrderController::class,'get'])->name("cache.order.get");
Route::get('/cache/order/delete', [OrderController::class,'delete'])->name("cache.order.delete");

Route::get('/cache/blog', [BlogController::class,'get'])->name("cache.blog.get");
Route::get('/cache/blog/delete', [BlogController::class,'delete'])->name("cache.blog.delete");