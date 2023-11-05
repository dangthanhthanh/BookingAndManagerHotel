<?php

// ini_set('memory_limit', '2G');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\ImageController;
use App\Http\Controllers\Client\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// upload image ckeditor
Route::post('/upload', [ImageController::class, 'uploadImageForDescription'])->name('upload.file');
Route::get('/', [HomeController::class,'index'])->name("home");


require_once "web/auth.php";
require_once "web/admin.php";
require_once "web/pos.php";
require_once "web/client.php";
require_once "web/payment.php";
require_once "web/cache.php";