<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index() {
        $bookings = Auth::user()->bookings;
        return view('bookings.index', compact('bookings'));
    }

    public function create() {
        $shops = Shop::all(); 
        return view('bookings.create', compact('shops'));
    }

    public function store(BookingRequest $request) {
        $validated = $request->validated();

        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->shop_id = $validated['shop_id'];
        $booking->booking_date = $validated['booking_date'];
        $booking->number = $validated['number'];
        $booking->save();

        return redirect()->route('bookings.index')->with('success', '予約が完了しました');
    }

    public function edit($id) {
        $booking = Booking::findOrFail($id);

        if (Auth::id() !== $booking->user_id) {
            return redirect()->route('home')->withErrors('該当する予約がありません');
        }

        $shops = Shop::all();
        return view('bookings.edit', compact('booking', 'shops'));
    }

    public function update(BookingRequest $request, $id) {
        $validated = $request->validated();

        $booking = Booking::findOrFail($id);
        if (Auth::id() !== $booking->user_id) {
            return redirect()->route('home')->withErrors('該当する予約がありません');
        }

        $booking->shop_id = $validated['shop_id'];
        $booking->booking_date = $validated['booking_date'];
        $booking->number = $validated['number'];
        $booking->save();

        return redirect()->route('bookings.index')->with('success', '予約が更新されました');
    }

    public function destroy($id) {
        $booking = Booking::findOrFail($id);
        if (Auth::id() !== $booking->user_id) {
            return redirect()->route('home')->withErrors('権限がありません');
        }
        
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', '予約が削除されました');
    }
}
