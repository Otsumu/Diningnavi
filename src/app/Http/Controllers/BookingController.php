<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(BookingRequest $request) {
    if (!Auth::check()) {
        return redirect()->route('register')->with('message', '会員登録をお願いします');
    }
    $data = $request->only(['shop_id', 'booking_date', 'booking_time', 'number']);
    $data['user_id'] = Auth::id(); 

    Booking::create($data);

    $request->session()->forget(['booking_date', 'booking_time']);

    return redirect()->route('booking.done');
  }

}
