<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Genre;
use App\Models\Area;
use App\Http\Requests\ShopRequest;
use Illuminate\Http\Request;

class ShopController extends Controller {

    public function __construct() {
        $this->middleware('auth')->except(['index', 'show','search']);
    }

    public function index(Request $request) {
        $genreId = $request->input('genre');
        $areaId = $request->input('area');
        $keyword = $request->input('keyword');
        $sort = $request->get('sort', 'random');

        $shops = Shop::query()
            ->genre($genreId)
            ->area($areaId)
            ->keyword($keyword);

        if ($sort === 'high_rating') {
            $shops->selectRaw('shops.*, IFNULL(MAX(comments.rating), 0) as max_rating')
                ->leftJoin('comments', 'comments.shop_id', '=', 'shops.id')
                ->withCount('comments')
                ->groupBy('shops.id')
                ->orderByRaw('max_rating DESC')
                ->orderByDesc('comments_count')
                ->orderByDesc('created_at');
        } elseif ($sort === 'low_rating') {
            $shops->selectRaw('shops.*, IFNULL(MIN(comments.rating), 0) as min_rating')
                ->leftJoin('comments', 'comments.shop_id', '=', 'shops.id')
                ->withCount('comments')
                ->groupBy('shops.id')
                ->orderByRaw('min_rating ASC')
                ->orderByDesc('comments_count')
                ->orderByDesc('created_at');
        } elseif ($sort === 'random') {
            $shops->inRandomOrder();
        }

        $shops = $shops->paginate(20);
        $areas = Area::all();
        $genres = Genre::all();

        return view('shop.index', compact('shops', 'areas', 'genres'));
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

    public function createComment(Shop $shop) {
        return view('shop.createComment', compact('shop'));
    }

    public function showComment($shopId) {
        session(['shopId' => $shop->id]);
        $shop = Shop::findOrFail($shopId);
        return view('shop.detail', compact('shop'));
    }

}