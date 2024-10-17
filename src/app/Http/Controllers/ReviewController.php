<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($bookingId) {
        $inputs = session("reviews_inputs.$bookingId",[]);
        $review = Review::where('booking_id', $bookingId)->first();
        $booking = Booking::with('shop')->where('id', $bookingId)->first();
        $shop_name = $booking->shop->name;
        $booking_date = $booking->booking_date;
            
        return view('review.form', compact('bookingId', 'review', 'booking','shop_name','booking_date'))->withInput($inputs);
    }

    public function confirm(ReviewRequest $request) {
        $validated = $request->validated();
        session(["reviews_inputs.{$validated['booking_id']}" => $validated]); 
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

        $booking = Booking::find($validated['booking_id']);
        $review->shop_id = $booking ? $booking->shop_id : null;
        
        $review->save();

        $request->session()->forget("reviews_inputs.{$validated['booking_id']}");

        return redirect()->route('user.users.mypage')->with('success-review', 'レビューが投稿されました');
    }

    public function editReview($id) {
        $review = Review::findOrFail($id);
        $shop_name = $review->booking->shop->name;
        $booking_date = $review->booking->booking_date;

        return view('review.edit',compact('review','shop_name','booking_date' ));
    }

    public function updateReview(ReviewRequest $request, $id) {
        $review = Review::findOrFail($id);
        $validatedData = $request->validated();
        $review->update($validatedData);

        return redirect()->route('user.users.mypage')->with('success-review','レビューが更新されました');
    }

    public function deleteReview($id) {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('user.users.mypage')->with('success-review','レビューを削除しました');
    }
}

