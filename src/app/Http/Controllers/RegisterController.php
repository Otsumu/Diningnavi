<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterConfirmMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller {

    public function index() {
        return view('user.register');
    }

    public function register(RegisterRequest $request) {
        $request->session()->put('register_data', $request->validated());
        return redirect()->route('user.confirm');
    }

    public function confirm() {
        $registerData = session('register_data');

        if (!$registerData) {
            return redirect()->route('user.register');
        }

        return view('user.confirm', ['data' => $registerData]);
    }

    public function store(Request $request) {
        $registerData = session('register_data');

        if (!$registerData) {
            return redirect()->route('user.register');
        }

        $user = User::create([
            'name' => $registerData['name'],
            'email' => $registerData['email'],
            'password' => Hash::make($registerData['password']),
        ]);

        auth()->login($user);
        event(new Registered($user));

        $request->session()->forget('register_data');

        Mail::to($user->email)->send(new RegisterConfirmMail($user));

        return redirect()->route('user.thanks');
    }

    public function thanks() {
        return view('user.thanks');
    }
}

