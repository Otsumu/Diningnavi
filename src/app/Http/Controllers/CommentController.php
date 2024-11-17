<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Booking;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function create(Shop $shop) {
        $bookingId = session('bookingId');
        return view('shop.createComment', compact('shop', 'bookingId'));
    }

    public function __construct() {
        $this->middleware('auth')->only('store', 'edit', 'delete');
        $this->middleware(function ($request, $next) {
            if ($request->routeIs('comments.delete') && auth()->user()->role !== 'admin' && auth()->id() !== $request->route('comment')->user_id) {
                return redirect()->route('shop.createComment', $request->route('comment')->shop_id)
                    ->withErrors('この口コミを削除する権限がありません');
            }
            return $next($request);
        })->only('delete');
    }

    public function store(CommentRequest $request) {
        $validated = $request->validated();

        $existingComment = Comment::where('booking_id', $validated['booking_id'])
                            ->where('user_id', Auth::id())
                            ->first();

        if ($existingComment) {
            return redirect()->route('shop.createComment')->withErrors([
                'content' => '口コミはすでに投稿されています。'
            ]);
        }

        $comment = new Comment();
        $comment->content = $validated['content'];
        $comment->rating = $validated['rating'];
        $comment->booking_id = $validated['booking_id'];
        $comment->user_id = Auth::id();

        $booking = Booking::find($validated['booking_id']);
        $comment->shop_id = $booking ? $booking->shop_id : null;
        $comment->save();

        $request->session()->forget("comments_inputs.{$validated['booking_id']}");

        return redirect()->route('shop.detailComment', ['shop' => $comment->shop_id, 'comment' => $comment->id])
            ->with('success', 'レビューが投稿されました');
    }

    public function detailComment(Shop $shop, Comment $comment) {
        return view('comments.detail', compact('shop', 'comment'));
    }
}