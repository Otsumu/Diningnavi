<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
  public function store(BookingRequest $request) {
    if (!Auth::check()) {
      return redirect()->route('user.menu2')->withErrors(['error' => '会員登録、もしくはログインしてください']);
    }
      
      $data = $request->only(['shop_id', 'booking_date', 'booking_time', 'number']);
      $data['user_id'] = Auth::id();

      Booking::create($data);

      $request->session()->forget(['booking_date', 'booking_time', 'number']);

      return redirect()->route('booking.done');
  }

  public function done() {
      return view('booking.done');
  }

  public function showUserBookings() {
      $user = Auth::user();
      $bookings = Booking::where('user_id', $user->id)->with('shop')->get();

      return view('user.users.mypage', compact('bookings'));
  }
}