<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function create() {
        return view('create');
    }

    public function store(Request $request) {
        Stripe::setApiKey(config('stripe.stripe_secret_key'));

        Charge::create([
            'source' => $request->stripeToken,
            'amount' => 5000,
            'currency' => 'jpy',
        ]);

        return back()->with('status', '決済が完了しました！');
    }
}