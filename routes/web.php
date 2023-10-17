<?php

// ini_set('memory_limit', '2G');


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\ImageController;
use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/test', function(){
//     // $guards = empty($guards) ? [null] : $guards;
//     // $token = Auth::user()->isManager();
//     dd(Auth::guard()->check());
//     // dd(Auth::user()->isCustomer());
//     dd([
//         'customer'=>Auth::user()->isCustomer(),
//         'staff'=>Auth::user()->isStaff(),
//         'admin'=>Auth::user()->isAdmin(),
//         'manager'=>Auth::user()->isManager(),
//         'cashier'=>Auth::user()->isCashier(),
//     ]);
// }
// )->name("test");


