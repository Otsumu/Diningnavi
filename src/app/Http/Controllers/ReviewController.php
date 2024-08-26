<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index() {
        $reviews = Auth::user()->reviews;
        return view('review.index',compact('reviews'));
    }

    public function create(Shop $shop) {
        return view('review.create',compact('shop'));
    }

    public function store(ReviewRequest $request) {
        $validated=$request->validated();

        $review= new Review();
        $review->title = $validated['title'] ?? null;
        $review->review = $validated['review'];
        $review->user_id = Auth::id();
        $review->save();

        return redirect()->route('review.index')->with('success','レビューが投稿されました');
    }

    public function edit($id) {
        $review=Review::findOrFail($id);
        if(Auth::id() !== $review->user_id) {
            return redirect()->route('home')->withErrors('権限がありません');
        }
        return view('review.edit',compact('review'));
    }

    public function update(ReviewRequest $request,$id) {
        $validated = $request->validated();

        $review = Review::findOrFail($id);
        if(Auth::id() !== $review->user_id) {
            return redirect()->route('home')->withErrors('権限がありません');
        }

        $review->title = $validated['title'] ?? $review->title;
        $review->review = $validated['review'] ?? $review->review;
        $review->save();

        return redirect()->route('review.index')->with('success','レビューを更新しました');
    }

    public function destroy($reviewId) {
        $review = Auth::user()->reviews()->find($reviewId);

        if(!$review) {
            return redirect()->back()->withErrors('指定のレビューが見つかりません');
        }

        $review->delete();
        return redirect()->back()->with('success','レビューを削除しました');
    }

}
