<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Favorite;
use App\Models\Review;

class UserController extends Controller {
    
    public function index() {
        $user = Auth::user();
        if ($user) {
            $bookings = $user->bookings;
            $favorites = $user->favorites;
            $reviews = $user->reviews;

            return view('user.index', compact('bookings', 'favorites', 'reviews'));
        } else {
            return redirect()->route('login')->withErrors('ログインしてください');
        }
    }

    public function destroyBooking($id) {
        $user = Auth::user();
        $booking = $user->bookings()->findOrFail($id);
        $booking->delete();

        return redirect()->route('user.index')->with('success', '予約がキャンセルされました');
    }

    public function updateBooking(Request $request, $id) {
        $user = Auth::user();
        $booking = $user->bookings()->findOrFail($id);
        $booking->update($request->all());

        return redirect()->route('user.index')->with('success', '予約内容が変更されました');
    }
}