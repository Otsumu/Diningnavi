@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review-form.css') }}">
@endsection

@section('content')
<div class="review-content">
    <h2>レビュー確認</h2>

    <div class="shop-info">
        <p style="font-size: 16px; margin-right: 10px;">
            <strong>ご利用店 :</strong>  {{ $validated['shop_name'] }}
        </p>
        <p style="font-size: 16px; margin-right: 10px;">
            <strong>ご利用日 :</strong>  {{ $validated['booking_date'] }}
        </p>
    </div>

    <div class="form-group">
        <label for="title">タイトル</label>
        <p>{{ $validated['title'] }}</p>
    </div>

    <div class="form-group">
        <label for="rating">評価</label>
        <div class="review__rating">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $validated['rating'])
                    <span class="star filled confirm-star">★</span>
                @else
                    <span class="star confirm-star">☆</span>
                @endif
            @endfor
        </div>
    </div>

    <div class="form-group">
        <label for="review">レビュー</label>
        <p>{{ $validated['review'] }}</p>
    </div>

    <div class="button-group">
        <form action="{{ route('review.store') }}" method="POST">
            @csrf
            <input type="hidden" name="title" value="{{ $validated['title'] }}">
            <input type="hidden" name="review" value="{{ $validated['review'] }}">
            <input type="hidden" name="rating" value="{{ $validated['rating'] }}">
            <input type="hidden" name="booking_id" value="{{ $validated['booking_id'] }}">
            <a href="{{ route('review.create', ['bookingId' => $validated['booking_id']]) }}" class="btn btn-cancel">修正する</a>
            <button type="submit" class="btn btn-review">投稿する</button>
        </form>
    </div>
</div>

@endsection