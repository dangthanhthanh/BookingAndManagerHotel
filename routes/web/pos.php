<?php

use Illuminate\Support\Facades\Route;

    Route::get('/food',  function (){
        return view("pos.page.food.index");
    })->name('pos.food');
    Route::get('/service',  function (){
        return view("pos.page.service.index");
    })->name('pos.service');
    Route::get('/room',  function (){
        return view("pos.page.room.index");
    })->name('pos.room');
    Route::get('/customer',  function (){
        return view("pos.page.customer.index");
    })->name('pos.customer');
