<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Favorite;
use App\Models\Review;

class UserController extends Controller {
    
    public function registerForm() {
        return view('user.register');
    }

    public function register(UserRequest $request) {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'user', 
        ]);

        Auth::login($user);
        return redirect()->route('user.my_page')->with('success', 'アカウントが作成されました');
    }

    public function loginForm() {
        return view('user.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('user.my_page');
        }
        return redirect()->back()->withErrors('ログインできません');
    }

    public function index() {
        $user = Auth::user();
        if ($user) {
            $bookings = $user->bookings;
            $favorites = $user->favorites;
            $reviews = $user->reviews;

            return view('user.users.my_page', compact('bookings', 'favorites', 'reviews'));
        } else {
            return redirect()->route('user.login')->withErrors('ログインしてください');
        }
    }

    public function destroyBooking($id) {
        $user = Auth::user();
        $booking = $user->bookings()->findOrFail($id);
        $booking->delete();

        return redirect()->route('user.my_page')->with('success', '予約がキャンセルされました');
    }

    public function updateBooking(Request $request, $id) {
        $user = Auth::user();
        $booking = $user->bookings()->findOrFail($id);
        $booking->update($request->all());

        return redirect()->route('user.my_page')->with('success', '予約内容が変更されました');
    }
}