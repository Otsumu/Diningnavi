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
        <form action="{{ route('comments.store', ['shop' => $shop->id]) }}" method="POST" accept="image/jpeg, image/png"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">

            <div class="form-group">
            <h2 class=right-comment-title>体験を評価してください</h2>
                <div id="rating">
                    <span class="star @if(old('rating') == 1) selected @endif" data-value="1">★</span>
                    <span class="star @if(old('rating') == 2) selected @endif" data-value="2">★</span>
                    <span class="star @if(old('rating') == 3) selected @endif" data-value="3">★</span>
                    <span class="star @if(old('rating') == 4) selected @endif" data-value="4">★</span>
                    <span class="star @if(old('rating') == 5) selected @endif" data-value="5">★</span>
                </div>
                <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', '') }}" required>
            </div>

            <div class="form-group">
            <h2 class=right-comment-title>口コミを投稿</h2>
                <textarea name="content" id="content" rows="5" placeholder="カジュアルな夜のお出かけにおすすめのスポット"
                required oninput="updateCharCount()">{{ old('content') }}</textarea>
                <p class="max-words" id="word-count">0/400(最大文字数)</p>
            </div>

            <div class="form-group">
                <h2 class="right-comment-title">画像の追加</h2>
                <div class="file-upload">
                    <input type="file" name="image" id="image" style="display: none;" enctype="multipart/form-data">
                    <span class="file-upload-placeholder">クリックして写真を追加またはドロップアンドドロップ</span>
                    <div id="image-preview" style="margin-top: 10px; display: none;">
                        <img id="preview-image" src="#" alt="Selected Image" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>

            <div class="shop__buttons">
                <button type="submit" class="btn btn-comment" id="submit-comment">口コミを投稿</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/detailComment.js') }}"></script>
@endsection