<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Booking;
use App\Models\Shop;
use App\Models\Favorite;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\BookingRequest;

class UserController extends Controller
{
    public function registerForm() {
        return view('user.register');
    }

    public function register(RegisterRequest $request) {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);
        return redirect()->route('user.thanks');
    }

    public function loginForm() {
        return view('user.login');
    }

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('user.users.menu1');
        }
        return redirect()->back();
    }

    public function showMenu2() {
        if(Auth::check()) {
            return redirect()->route('user.users.menu1');
        }
        return view('user.menu2');
    }

    public function showMenu1() {
        return view('user.users.menu1');
    }

    public function myPage() {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)->with('shop')->get();
        $favorites = $user->favorites;
    
        return view('user.users.mypage', compact('bookings', 'favorites'));
    }

    public function editBooking($id) {
        $booking = Booking::findOrFail($id);
        $shop = Shop::findOrFail($booking->shop_id);

        return view('user.users.form', compact('booking', 'shop'));
    }

    public function updateBooking(BookingRequest $request, $id) {
        $booking = Booking::findOrFail($id);
        $booking->update($request->validated());

        return redirect()->route('mypage')->with('success', '予約が更新されました');
    }

    public function destroyBooking($id) {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('mypage')->with('success', 'ご予約をキャンセルしました');
    }
}