<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
   public function store(Request $request, $shopId) {
        $exists = Auth::user()->favorites()->where('shop_id', $shopId)->exists();

        if (!$exists) {
            Auth::user()->favorites()->create([
                'shop_id' => $shopId,
            ]);
            return redirect()->back()->with('success', '店舗をお気に入りに追加しました');
        }

        return redirect()->back()->with('error', 'この店舗は既にお気に入りに追加されています');
    }

    public function destroy($shopId) {
        Auth::user()->favorites()->where('shop_id', $shopId)->delete();

        return redirect()->back()->with('success', '店舗をお気に入りから削除しました');
    }
}