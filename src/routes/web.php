<?php

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

Route::get('/', [ShopController::class, 'index']);
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/detail/{shop_id}',[ShopController::class,'show']);
Route::middleware('auth')->group(function () {
Route::post('/shop/{shop}/booking', [ShopController::class, 'createBooking'])->name('shop.booking');
Route::post('/booking', [BookingController::class, 'store'])->name('booking');
Route::get('/booking/done', [BookingController::class, 'done'])->name('booking.done');
});



