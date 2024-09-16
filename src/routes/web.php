<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FavoriteController;
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
    Route::get('/user/users/menu1', [UserController::class, 'showMenu1'])->name('user.users.menu1');
    Route::post('/shop/{shop}/booking', [BookingController::class, 'createBooking'])->name('shop.booking');
    Route::get('/booking/done', [BookingController::class, 'done'])->name('booking.done');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/user/users/mypage', [UserController::class, 'myPage'])->name('mypage');

    Route::get('/user/users/form/{id}/edit', [UserController::class, 'editBooking'])->name('booking.edit');
    Route::patch('/user/users/form/{id}', [UserController::class, 'updateBooking'])->name('booking.update');
    Route::delete('/user/users/form/{id}', [UserController::class, 'destroyBooking'])->name('booking.cancel');
    
    Route::get('/user/users/favorites', [UserController::class, 'indexFavorites'])->name('user.users.favorites');
    Route::post('/user/users/mypage/add/{shopId}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/user/users/mypage/remove/{shopId}', [FavoriteController::class, 'remove'])->name('favorites.remove');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});



