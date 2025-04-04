<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Booking;
use App\Models\Shop;
use App\Models\Review;
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
        $loginData = $request->session()->get('login_data', []);
        return view('user.login', ['loginData' => $loginData]);
    }

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->forget('login_data');
            return redirect()->route('user.users.menu1');
        }
        $request->session()->put('login_data', $request->only('email', 'password'));
        return redirect()->back()->withInput();
    }

    public function showMenu2() {
        if (Auth::check()) {
            return redirect()->route('user.users.menu1');
        }
        session()->flash('menu2-error', '会員登録、もしくはログインが必要です');
        return view('user.menu2');
    }

    public function showMenu1() {
        return view('user.users.menu1');
    }

    public function myPage() {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)->with('shop')->get();
        $favorites = $user->favorites;

        $bookingId = $bookings->isNotEmpty() ? $bookings->last()->id : null;
        $reviews = Review::where('user_id', $user->id)->with('booking.shop')->get();

        return view('user.users.mypage', compact('bookings', 'favorites', 'reviews'));
    }

    public function editBooking($id) {
        $booking = Booking::findOrFail($id);
        if (!$booking->shop_id) {
            return redirect()->route('user.users.mypage')->with('error', '予約が見つかりませんでした。');
        }

        $shop = Shop::findOrFail($booking->shop_id);

        return view('user.users.form', compact('booking', 'shop'));
    }

    public function updateBooking(BookingRequest $request, $id) {
        $booking = Booking::findOrFail($id);
        $booking->update($request->validated());

        return redirect()->route('user.users.mypage')->with('success', '予約が更新されました');
    }

    public function destroyBooking($id) {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('user.users.mypage')->with('success', 'ご予約をキャンセルしました');
    }
}