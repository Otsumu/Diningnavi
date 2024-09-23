<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Genre; 
use App\Models\Area; 
use App\Http\Requests\ShopRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller {

    public function __construct() {
        $this->middleware('auth')->except(['index', 'show','search']);
    }

    public function index(Request $request) {
        $genreId = $request->input('genre');
        $areaId = $request->input('area');
        $keyword = $request->input('keyword');
        
        $shops = Shop::query()
            ->genre($genreId)
            ->area($areaId)
            ->keyword($keyword)
            ->get();

        $areas = Area::all();
        $genres = Genre::all();
        
        return view('shop.index', compact('shops','areas','genres'));
    }

    public function show($shop_id) {
        $shop = Shop::findOrFail($shop_id);
        $backRoute = route('home');
        $bookingData = session('booking_data', []);
    
        return view('shop.detail', compact('shop', 'backRoute', 'bookingData'));
    }

    public function createBooking(BookingRequest $request) {

        $data = $request->only(['shop_id', 'booking_date', 'booking_time', 'number']);
        $request->session()->put('booking_data', $data);

        return redirect()->route('booking.done');
    }

    public function create() {
        return view('shop.form');
    }

    public function store(ShopRequest $request) {
        $validated = $request->validated();

        $shop = Shop::create([
            'name' => $validated['name'],
            'genre_id' => $validated['genre_id'],
            'area_id' => $validated['area_id'],
        ]);

        return redirect()->route('shop.detail', $shop->id)->with('success', '店舗情報を作成しました');
    }

    public function edit($id) {
        $shop = Shop::findOrFail($id);
        return view('shop.form', compact('shop'));
    }

    public function update(ShopRequest $request, $id) {
        $validated = $request->validated();

        $shop = Shop::findOrFail($id);
        $shop->update($validated);

        return redirect()->route('shop.detail', $id)->with('success', '店舗情報を更新しました');
    }

}