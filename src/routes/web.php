<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/user/menu2', [UserController::class, 'showMenu2'])->name('user.menu2');
Route::get('/detail/{shop_id}', [ShopController::class, 'show']);
Route::get('/user/register', [RegisterController::class, 'index'])->name('user.register');
Route::post('/user/register', [RegisterController::class, 'register']);
Route::get('/user/thanks', [RegisterController::class, 'thanks'])->name('user.thanks');
Route::get('/user/confirm', [RegisterController::class, 'confirm'])->name('user.confirm');
Route::post('/user/confirm', [RegisterController::class, 'store']);
Route::get('/user/login', [LoginController::class, 'index'])->name('user.login');
Route::post('/user/login', [LoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/user/users/menu1', [UserController::class,'showMenu1'])->name('user.users.menu1');
    Route::post('/shop/{shop}/booking', [ShopController::class, 'createBooking'])->name('shop.booking');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking');
    Route::get('/booking/done', [BookingController::class, 'done'])->name('booking.done');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});



