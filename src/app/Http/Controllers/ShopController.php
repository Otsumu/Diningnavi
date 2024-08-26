<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller {
    
    public function index() {
        $shops = Shop::all(); 
        return view('shops.index', compact('shops'));
    }

    public function show($id) {
        $shop = Shop::findOrFail($id);
        return view('shops.show', compact('shop'));
    }

    // 検索機能
    public function search(Request $request)
    {
        // 検索ロジック
    }
}