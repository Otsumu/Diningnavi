<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create() {
        $shops = Shop::all();
        return view('booking.form', compact('shops'));
    }

    public function confirm(Request $request) {
        $request->session()->put('booking_datetime', $request->all());

        return view('booking.confirm', [
            'booking' => $request->all()
        ]);
    }

    public function store(Request $request) {
        $bookingDateTime = $request->session()->get('booking_datetime');

        Booking::create($bookingDateTime + ['user_id' => Auth::id()]);

        $request->session()->forget('booking_datetime');

        return redirect()->route('booking.done');
    }
}
