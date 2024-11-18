<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Booking;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function create(Shop $shop) {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }
        return view('shop.createComment', compact('shop'));
    }

    public function __construct() {
        $this->middleware('auth')->only('store', 'edit', 'delete');
        $this->middleware(function ($request, $next) {
            if ($request->routeIs('comments.delete') && auth()->user()->role !== 'admin' && auth()->id() !== $request->route('comment')->user_id) {
                return redirect()->route('shop.createComment', $request->route('comment')->shop_id)
                    ->withErrors('口コミを削除できません');
            }
            return $next($request);
        });
    }

    public function store(CommentRequest $request) {
        $validated = $request->validated();
        $shopId = $request->input('shop_id');
        $existingComment = Comment::where('shop_id', $shopId)
            ->where('user_id', Auth::id())
            ->exists();

        if ($existingComment) {
            return redirect()->route('shop.createComment', ['shop' => $shopId])
                ->withErrors(['content' => 'この店舗にはすでに口コミが投稿されています']);
        }

        $comment = new Comment();
        $comment->content = $validated['content'];
        $comment->rating = $validated['rating'];
        $comment->user_id = Auth::id();
        $comment->shop_id = $shopId;
        $comment->save();

        return redirect()->route('shop.detailComment', ['shop' => $comment->shop_id, 'comment' => $comment->id])
            ->with('success', '口コミが投稿されました。');
    }

    public function detailComment(Shop $shop, Comment $comment) {
        return view('shop.detailComment', compact('shop', 'comment'));
    }

    public function edit(Shop $shop, Comment $comment) {
        if (auth()->id() !== $comment->user_id && auth()->user()->role !== 'admin') {
            return redirect()->route('shop.detailComment', ['shop' => $shop->id, 'comment' => $comment->id])
                ->withErrors('このコメントは編集できません');
        }

        return view('shop.edit', compact('shop', 'comment'));
    }

    public function update(CommentRequest $request, Shop $shop, Comment $comment) {
        if (auth()->id() !== $comment->user_id) {
            return redirect()->route('shop.detailComment', ['shop' => $shop->id, 'comment' => $comment->id])
                ->withErrors('このコメントは編集できません');
        }

        $comment->content = $request->content;
        $comment->rating = $request->rating;
        $comment->save();

        return redirect()->route('shop.detailComment', ['shop' => $shop->id, 'comment' => $comment->id])
            ->with('success', '口コミが更新されました');
    }

    public function delete(Shop $shop, Comment $comment) {
        if (auth()->id() !== $comment->user_id) {
            return redirect()->route('shop.detailComment', ['shop' => $shop->id, 'comment' => $comment->id])
                ->withErrors('このコメントは削除できません');
        }
        $comment->delete();

        return redirect()->route('shop.detailComment', ['shop' => $shop->id])
            ->with('success', '口コミが削除されました');
    }
}