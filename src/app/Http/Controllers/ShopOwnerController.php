<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ShopRequest;
use App\Models\User;
use App\Models\Shop;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Genre;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ShopOwnerController extends Controller
{   
    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isShopOwner()) {
                return redirect()->route('shop_owner.login');
            }
            return $next($request);
        })->except(['registerForm','register','confirm','store','loginForm', 'login']);
    }

    public function registerForm() {
        return view('shop_owner.register');
    }

    public function register(RegisterRequest $request) {
        $validated = $request->validated();
        $request->session()->put('register_data', $validated);
    
        return redirect()->route('shop_owner.confirm');
    }

    public function confirm() {
        $registerData = session('register_data');
    
        if (!$registerData) {
            return redirect()->route('shop_owner.register');
        }
    
        return view('shop_owner.confirm', ['data' => $registerData]);
    }

    public function store(Request $request) {
        $registerData = session('register_data');

        if (!$registerData) {
            return redirect()->route('shop_owner.register');
        }

        $user = User::create([
            'name' => $registerData['name'],
            'email' => $registerData['email'],
            'password' => Hash::make($registerData['password']),
            'role' => 'shop_owner', 
        ]);

        Auth::login($user);
        $request->session()->forget('register_data');

        return redirect()->route('shop_owner.login')->with('message', '会員登録できました');
    }

    public function loginForm() {
        return view('shop_owner.login');
    }

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->isShopOwner()) {
            return redirect()->route('shop_owner.shops.index');
        }
        return redirect()->back()->withErrors('ログインできません');
    }

    public function create() {
        return view('shop_owner.shops.form');
    }

    public function storeForm(ShopRequest $request) {
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

    public function destroy(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->flash('success', 'ログアウトしました');

        return redirect('/');
    }

}
