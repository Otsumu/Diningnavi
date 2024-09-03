<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Shop;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Genre;  
use App\Models\Area;   
use Illuminate\Support\Facades\Auth;

class ShopOwnerController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isShopOwner()) {
                return redirect()->route('shop_owner.login')->withErrors('権限がありません');
            }
            return $next($request);
        });
    }

    public function shopownerRegisterForm() {
        return view('shop_owner.register');
    }

    public function shopownerRegister(Request $request) {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'shop_owner',
        ]);

        Auth::login($user);
        return redirect()->route('shop_owner.login')->with('success', '店舗代表者アカウントが作成されました');
    }

    public function shopownerLoginForm() {
        return view('shop_owner.login');
    }

    public function shopownerLogin(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->isShopOwner()) {
            return redirect()->route('shop_owner.shops.index');
        }
        return redirect()->back()->withErrors('ログインできません');
    }

    public function create() {
        return view('shop_owner.shops.form');
    }

    public function store(Request $request) {
        $shop = Auth::user()->shops()->create($request->validated());

        return redirect()->route('shop_owner.shops.index')->with('success', '店舗情報を作成しました');
    }

    public function edit($id) {
        $shop = Auth::user()->shops()->findOrFail($id);
        $genres = Genre::all();
        $areas = Area::all(); 
    
        return view('shop_owner.shops.form', compact('shop', 'genres', 'areas'));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,shop_owner,regular_user',
        ]);

        $shop = Auth::user()->shops()->findOrFail($id);
        $shop -> update($request->validated());

        return redirect()->route('shop_owner.shops.index')->with('success', '店舗情報を更新しました');
    }

    public function bookingsIndex() {
        $shopIds = Auth::user()->shops()->pluck('id');
        $bookings = Booking::whereIn('shop_id', $shopIds)->get();

        return view('shop_owner.shops.bookings',compact('bookings'));
    }

}
