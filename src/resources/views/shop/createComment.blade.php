@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detailComment.css') }}">
@endsection

@section('content')
<div class="shop__content">
    <div class="shop__left-content">
        @if(session('error'))
            <div class="alert alert-danger" style="color: red; font-weight: bold; margin-bottom: 10px;">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="left-comment-title">今回のご利用はい<br>かがでしたか？</h1>
            <div class="shop__item">
                <div class="shop__img">
                    <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}" class="shop__img">
                </div>
                <div class="shop__detail">
                    <h2>{{ $shop->name }}</h2>
                    <p>#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
                </div>
                <div class="shop__buttons">
                    <a href="/detail/{{ $shop->id }}" class="btn btn-details">詳しくみる</a>
                    <button class="favorite-shop" type="button" data-shop-id="{{ $shop->id }}" data-favorited="{{ $shop->isFavorited ? 'true' : 'false' }}" onclick="changeColor(this)">  
                        <i class="fa-solid fa-heart {{ $shop->isFavorited ? 'active' : '' }} heart-icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="shop__right-content">
        <form action="{{ route('comments.store', ['shop' => $shop->id]) }}" method="POST">
        @csrf
            <div class="form-group">
            <h2 class=right-comment-title>体験を評価してください</h2>
                <div id="rating">
                    <span class="star @if(old('rating', session("comments_inputs." . $bookingId . ".rating")) == 1) selected @endif" data-value="1">★</span>
                    <span class="star @if(old('rating', session("comments_inputs." . $bookingId . ".rating")) == 1) selected @endif" data-value="2">★</span>
                    <span class="star @if(old('rating', session("comments_inputs." . $bookingId . ".rating")) == 1) selected @endif" data-value="3">★</span>
                    <span class="star @if(old('rating', session("comments_inputs." . $bookingId . ".rating")) == 1) selected @endif" data-value="4">★</span>
                    <span class="star @if(old('rating', session("comments_inputs." . $bookingId . ".rating")) == 1) selected @endif" data-value="5">★</span>
                </div>
                <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', session("comments_inputs.$bookingId.rating", '')) }}" required>
            </div>

            <div class="form-group">
            <h2 class=right-comment-title>口コミを投稿</h2>
                <textarea name="comment" id="comment" rows="5" placeholder="カジュアルな夜のお出かけにおすすめのスポット"
                required>{{ old('comment', session("comments_inputs.$bookingId.comment", '')) }}</textarea>
                <p class="max-words">0/400(最大文字数)</p>
            </div>

            <div class="form-group">
            <h2 class="right-comment-title">画像の追加</h2>
                <textarea id="image" name="image" rows="5" placeholder="クリックして写真を追加またはドロップアンドドロップ" class="form-control"></textarea>
            </div>

            <div class="shop__buttons">
                <button type="submit" class="btn btn-comment" id="submit-comment">口コミを投稿</button>
            </div>
        </form>
    </div>
    @endsection

@section('js')
<script src="{{ asset('js/detailComment.js') }}"></script>
@endsection