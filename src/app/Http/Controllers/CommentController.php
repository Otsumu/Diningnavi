<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Booking;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function create(Shop $shop) {
        $bookingId = session('bookingId');
        return view('shop.createComment', compact('shop', 'bookingId'));
    }

    public function store(CommentRequest $request, Shop $shop) {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'ログインが必要です');
        }
        Comment::create([
            'shop_id' => $shop->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return redirect()->route('shop.show', $shop)->with('success', '口コミを投稿しました');
    }

    public function edit(Shop $shop, Comment $comment) {
        if ($comment->user_id !== auth()->id()) {
            return redirect()->route('shop.show', $shop)->with('error', 'このコメントは編集できません');
        }
        return view('comments.edit', compact('shop', 'comment'));
    }

    public function update(Request $request, Shop $shop, Comment $comment) {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $comment->update([
            'comment' => $request->comment,
        ]);

        return redirect()->route('shop.show', $shop)->with('success', '口コミを更新しました');
    }

    public function destroy(Shop $shop, Comment $comment) {
        if ($comment->user_id !== auth()->id()) {
            return redirect()->route('shop.show', $shop)->with('error', 'このコメントは削除できません');
        }
        $comment->delete();

        return redirect()->route('shop.show', $shop)->with('success', '口コミを削除しました');
    }
}
