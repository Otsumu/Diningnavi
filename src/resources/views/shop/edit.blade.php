@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/createComment.css') }}">
@endsection

@section('content')
<div class="shop__content">
    <div class="shop__left-content">
        @if ($errors->any())
        <div class="custom-error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
        <form action="{{ route('comments.update', ['shop' => $shop->id, 'comment' => $comment->id]) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="shop_id" value="{{ $shop->id, $comment->id }}">

            <div class="form-group">
            <h2 class=right-comment-title>体験を評価してください</h2>
            <div class="form-group">
                <div id="rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}" style="color: {{ $i <= old('rating', $comment->rating) ? 'rgb(63, 90, 242)' : 'lightgray' }}">★</span>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', $comment->rating) }}" required>
            </div>

            <div class="form-group">
            <h2 class=right-comment-title>口コミを投稿</h2>
                <textarea name="content" id="content" rows="5" placeholder="カジュアルな夜のお出かけにおすすめのスポット"
                required>{{ old('content', $comment->content ) }}</textarea>
                <p class="max-words" id="word-count">0/400(最大文字数)</p>
            </div>

            <div class="form-group">
                <h2 class="right-comment-title">画像の追加</h2>
                <div class="file-upload">
                    <input type="file" name="image" id="image" accept="image/*" style="display: none;">
                    <span class="file-upload-placeholder">
                        クリックして写真を追加またはドロップアンドドロップ
                    </span>
                    <div id="image-preview" style="margin-top: 10px; display: none;">
                        <img id="preview-image" src="#" alt="Selected Image" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>

            <div class="shop__buttons">
                <button type="submit" class="btn btn-comment" id="submit-comment">口コミを更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/edit.js') }}"></script>
@endsection