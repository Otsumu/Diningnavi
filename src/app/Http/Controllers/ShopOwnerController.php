<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\User; 
use App\Models\Shop;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ShopOwnerController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isShopOwner()) {
                return redirect()->route('shopowner.register')->withErrors('権限がありません');
            }
            return $next($request);
        });
    }

    public function shopownerRegisterForm() {
        return view('shopowner.register');
    }

    public function shopownerRegister(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'shop_owner',
        ]);

        Auth::login($user);
        return redirect()->route('shopowner.login')->with('success', '店舗代表者アカウントが作成されました');
    }

    public function shopownerLoginForm() {
        return view('shopowner.login');
    }

    public function shopownerLogin(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->isShopOwner()) {
            return redirect()->route('shopowner.shops.index');
        }
        return redirect()->back()->withErrors('ログインできません');
    }

    public function create() {
        return view('shopowner.shops.create');
    }

    public function store(ShopRequest $request) {
        $shop = Auth::user()->shops()->create($request->validated());
        return redirect()->route('shopowner.shops.index')->with('success', '店舗情報を作成しました');
    }

    public function edit($id) {
        $shop = Auth::user()->shops()->findOrFail($id);
        $genres = Genre::all();
        $areas = Area::all(); 
    
        return view('shopowner.shops.edit', compact('shop', 'genres', 'areas'));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,shop_owner,regular_user',
        ]);

        $shop = Auth::user()->shops()->findOrFail($id);
        $shop -> update($request->validated());

        return redirect()->route('shopowner.shops.index')->with('success', '店舗情報を更新しました');
    }

    public function index() {
        $shopIds = Auth::user()->shops()->pluck('id');
        $bookings = Booking::whereIn('shop_id', $shopIds)->get();

        return view('shopowner.bookings',compact('bookings'));
    }

}
