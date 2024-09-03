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

    public function index() {
        $shops = Shop::all(); 
        return view('shop.index', compact('shops'));
    }

    public function show($shop_id) {
        $shop = Shop::findOrFail($shop_id);
        return view('shop.detail', compact('shop'));
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

    public function search(Request $request) {
        $genreId = $request->input('genre_id');
        $areaId = $request->input('area_id');
        $keyword = $request->input('keyword');
        
        $shops = Shop::query()
            ->genre($genreId)
            ->area($areaId)
            ->keyword($keyword)
            ->get();
        
        return view('shop.index', [
            'shops' => $shops,
            'areas' => Area::all(),
            'genres' => Genre::all(),
        ]);
    }
}