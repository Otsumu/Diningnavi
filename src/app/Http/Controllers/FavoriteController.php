<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function showMyPage() {
        $user = Auth::user();

        $shops = Shop::whereHas('favorites', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with('area', 'genre')
        ->get();

        return view('user.users.mypage', compact('shops'));
    }


    public function add(Request $request, $shopId) {
      $user = Auth::user();
      
      Favorite::create([
        'user_id' => $user->id,
        'shop_id' => $shopId,
      ]);
      return response()->json([]);
    } 

    public function remove(Request $request, $shopId) {
      $user = Auth::user();
      $favorite = Favorite::where('user_id', $user->id)
      ->where('shop_id', $shopId)
      ->first();

      if($favorite) {
        $favorite->delete();
      }

      return response()->json(['success' => true]);
   }
}