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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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
        $shop = Auth::user()->shops()->get();
        return view('shop_owner.shops.menu');
    }

    public function bookingsIndex() {
        $shopOwnerId = Auth::id();
        $bookings = Booking::whereHas('shop', function($query) use ($shopOwnerId) {
            $query->where('shop_owner_id', $shopOwnerId);
        })->with('user', 'shop')->paginate(10); 
    
        return view('shop_owner.shops.bookings', compact('bookings'));
    }

    public function showForm() {
        $areas = Area::all();
        $genres = Genre::all();
        return view('shop_owner.shops.form', compact('areas', 'genres'));
    }

    public function showConfirm() {
        $inputs = session('shop_inputs', []);
        $areas = Area::all();
        $genres = Genre::all();
        return view('shop_owner.shops.confirm', compact('inputs', 'areas','genres'));
    }
    
    public function confirmForm(ShopRequest $request) {
        $inputs = $request->all();
        $areas = Area::all(); 
        $genres = Genre::all();

        session(['shop_inputs' => $inputs]); 

        return redirect()->route('shop_owner.shops.confirm.view');
    }

    public function index() {
        $shops = Auth::user()->shops()->with('area', 'genre')->paginate(5);
        return view('shop_owner.shops.index', compact('shops'));
    }

    public function storeForm(ShopRequest $request) {
        $shopData = $request->only(['name','intro','image_url','genre_id','area_id']);
        $shopData['shop_owner_id'] = Auth::id();
        $shop = Auth::user()->shops()->create($shopData);

        return redirect()->route('shop_owner.shops.index')->with('success', '新規店舗を登録しました');
    }

    public function edit($id) {
        $shop = Auth::user()->shops()->findOrFail($id);
        $genres = Genre::all();
        $areas = Area::all(); 
    
        return view('shop_owner.shops.edit', compact('shop', 'genres', 'areas'));
    }

    public function update(ShopRequest $request, $id) {
        $shop = Auth::user()->shops()->findOrFail($id);
        $shop -> update($request->validated());

        return redirect()->route('shop_owner.shops.index')->with('success', '店舗情報を更新しました');
    }

    public function delete($id) {
        $shop = Shop::findOrFail($id);
        $shop->delete();

        return redirect()->route('shop_owner.shops.index')->with('success', '店舗情報を削除しました');
    }

    public function showImageUploadForm() {
        return view('shop_owner.shops.image_upload');
    }
    
    public function saveImageFromUrl(Request $request) {
        $imageUrl = $request->input('image_url');
        $response = Http::get($imageUrl);
    
        if ($response->successful()) {
            $fileName = basename($imageUrl);
            Storage::disk('public')->put("images/{$fileName}", $response->body());
        }
            return response()->json(['message' => '画像を保存しました']);
    }

    public function destroy(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->flash('success', 'ログアウトしました');

        return redirect()->route('shop_owner.login');
    }
}
