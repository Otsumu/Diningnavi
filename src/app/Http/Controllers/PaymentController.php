<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Booking;

class PaymentController extends Controller
{
    public function create($bookingId) {
        $booking = Booking::find($bookingId);
        if (!$booking) {
            return redirect()->back()->withErrors(['booking' => '予約が見つかりませんでした。']);
        }

        return view('create', compact('booking'));
    }

    public function store(Request $request) {
        $bookingId = $request->input('booking_id');
        $booking = Booking::find($bookingId);

        if ($booking->payment_status === 1) {
            return back()->withErrors(['payment' => 'この予約は既に支払いが完了しています']);
        }

        Stripe::setApiKey(config('stripe.stripe_secret_key'));

        try {
            $charge = \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => 5000,
                'currency' => 'jpy',
            ]);

        $booking->payment_status = 1;
        $booking->save();

        return back()->with('status', '決済が完了しました！');
        }
    catch (\Stripe\Exception\CardException $e) {
        return back()->withErrors(['payment' => $e->getMessage()]);
        }
    }
}