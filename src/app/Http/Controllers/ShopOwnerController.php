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
            return redirect()->route('shop_owner.shops.menu');
        }
        return redirect()->back()->withErrors('ログインできません');
    }

    public function menu() {
        return view('shop_owner.shops.menu');
    }

    public function showForm() {
        $areas = Area::all();
        $genres = Genre::all();
        return view('shop_owner.shops.form', compact('areas', 'genres'));
    }

    public function confirmForm(ShopRequest $request) {
        $inputs = $request->all();
        $areas = Area::all(); 
        $genres = Genre::all();

        session(['shop_inputs' => $inputs]); 

        return redirect()->route('shop_owner.shops.confirm.view');
    }

    public function showConfirm() {
        $inputs = session('shop_inputs', []);
        $areas = Area::all();
        $genres = Genre::all();
        return view('shop_owner.shops.confirm', compact('inputs', 'areas','genres'));
    }

    public function storeForm(Request $request) {
        $shop = Auth::user()->shops()->create($request->all());
        return redirect()->route('shop_owner.shops.index')->with('success', '新規店舗を登録しました');
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
        $shopOwnerId = Auth::id();
        $bookings = Booking::whereHas('shop',function($query) use ($shopOwnerId) {
          $query->where('shop_owner_id',$shopOwnerId);
        })->with('user', 'shop')->paginate(5); 

        return view('shop_owner.shops.bookings',compact('bookings'));
    }

    public function destroy(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->flash('success', 'ログアウトしました');

        return redirect()->route('shop_owner.login');
    }

}
