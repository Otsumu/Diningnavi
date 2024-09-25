<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($bookingId) {

        $review = Review::where('booking_id', $bookingId)->first();

        $booking = Booking::with('shop')->where('id', $bookingId)->first();
        $shop_name = $booking->shop->name;
        $booking_date = $booking->booking_date;
            
        return view('review.form', compact('bookingId', 'review', 'booking','shop_name','booking_date'));
    }

    public function confirm(ReviewRequest $request) {
        $validated = $request->validated();

        $booking = Booking::with('shop')->findOrFail($validated['booking_id']);
        $validated['shop_name'] = $booking->shop->name;
        $validated['booking_date'] = $booking->booking_date;

        return view('review.confirm', compact('validated'));
    }

    public function store(ReviewRequest $request) {
        $validated = $request->validated();

        $review = new Review();
        $review->title = $validated['title'] ?? null;
        $review->review = $validated['review'];
        $review->rating = $validated['rating'];
        $review->booking_id = $validated['booking_id'];
        $review->user_id = Auth::id();
        $review->save();

        return redirect()->route('user.users.mypage')
        ->with('success', 'レビューが投稿されました');
    }

    public function edit($id) {
        $review = Review::findOrFail($id);
        if (Auth::id() !== $review->user_id) {
            return redirect()->route('review.index')->withErrors('投稿できません');
        }
        return view('review.form', compact('review'));
    }

    public function update(ReviewRequest $request, $id) {
        $validated = $request->validated();

        $review = Review::findOrFail($id);
        if (Auth::id() !== $review->user_id) {
            return redirect()->route('review.index')->withErrors('更新できません');
        }

        $review->title = $validated['title'] ?? $review->title;
        $review->review = $validated['review'] ?? $review->review;
        $review->rating = $validated['rating'] ?? $review->rating;
        $review->save();

        return redirect()->route('review.index')->with('success', 'レビューを更新しました');
    }

    public function destroy($reviewId) {
        $review = Auth::user()->reviews()->find($reviewId);

        if (!$review) {
            return redirect()->back()->withErrors('指定のレビューが見つかりません');
        }

        $review->delete();
        return redirect()->back()->with('success', 'レビューを削除しました');
    }
}

