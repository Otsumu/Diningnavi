@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review-form.css') }}">
@endsection

@section('content')
<div class="review-content">
    <h2>レビュー投稿</h2>
    <div class="shop-info">
        <p style="font-size: 16px; margin-right: 10px;">
            <strong>ご利用店 :</strong> {{ $shop_name ?? '不明' }}
        </p>
        <p style="font-size: 16px; margin-right: 10px;">
            <strong>ご利用日 :</strong> {{ $booking_date ?? '不明' }}
        </p>
    </div>
    <form action="{{ route('review.confirm') }}" method="GET">
        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title', session("reviews_inputs.$bookingId.title", '')) }}"  required>
        </div>

        <div class="form-group">
            <label>評価</label>
            <div id="rating">
                <span class="star @if(old('rating', session("reviews_inputs.$bookingId.rating")) == 1) selected @endif" data-value="1">★</span>
                <span class="star @if(old('rating', session("reviews_inputs.$bookingId.rating")) == 2) selected @endif" data-value="2">★</span>
                <span class="star @if(old('rating', session("reviews_inputs.$bookingId.rating")) == 3) selected @endif" data-value="3">★</span>
                <span class="star @if(old('rating', session("reviews_inputs.$bookingId.rating")) == 4) selected @endif" data-value="4">★</span>
                <span class="star @if(old('rating', session("reviews_inputs.$bookingId.rating")) == 5) selected @endif" data-value="5">★</span>
            </div>
            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', session("reviews_inputs.$bookingId.rating", '')) }}" required>
        </div>

        <div class="form-group">
            <label for="review">レビュー</label>
            <textarea name="review" id="review" rows="5" required>{{ old('review', session("reviews_inputs.$bookingId.review", '')) }}</textarea>
        </div>

        <div class="button-group">
            <a href="{{ url()->previous() }}" class="btn btn-secondary border-secondary">戻る</a>
            <button type="submit" class="btn btn-review">確認する</button>
        </div>
    </form>
</div>
@endsection

@section('js')
<script src="{{ asset('js/form.js') }}"></script>
@endsection
