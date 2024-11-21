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

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
            $comment->image = $imagePath;
        }

        $comment->save();

        return redirect()->route('shop.detailComment', ['shop' => $comment->shop_id, 'comment' => $comment->id])
            ->with('success', '口コミが投稿されました');
    }

    public function detailComment(Shop $shop, Comment $comment) {
        return view('shop.detailComment', compact('shop', 'comment'));
    }

    public function edit(Shop $shop, Comment $comment) {
        if (auth()->id() !== $comment->user_id ) {
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

    public function __construct() {
        $this->middleware('auth')->only('delete');
    }

    public function delete(Shop $shop, Comment $comment) {
        if (auth()->id() !== $comment->user_id) {
            return redirect()->route('shop.detailComment',['shop' => $shop->id, 'comment' => $comment->id])
                ->withErrors('このコメントを削除できません');
        }

        $comment->delete();
        return redirect()->route('shop.detail', ['shop_id' => $shop->id])
            ->with('success', '口コミが削除されました');
    }

    public function index(Request $request) {
        $sort = $request->get('sort', 'newest');
        $comments = Comment::query();
        switch ($sort) {
            case 'newest':
                $comments->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $comments->orderBy('created_at', 'asc');
                break;
            case 'highest_rating':
                $comments->orderBy('rating', 'desc');
                break;
            case 'lowest_rating':
                $comments->orderBy('rating', 'asc');
                break;
            default:
                $comments->orderBy('created_at', 'desc');
                break;
        }

        $comments = $comments->paginate(10);
        return view('shop.commentsIndex', compact('comments', 'sort'));
    }
}