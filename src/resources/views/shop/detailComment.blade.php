@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detailComment.css') }}">
@endsection

@section('content')
<div class="shop__content">
    <div class="homepage">
        @if (session('success'))
            <div class="alert alert-success"
            style="background-color: #cce5ff; color: #004085; padding: 7px; font-size: 12px; border-radius: 5px; border: 1px solid #b8daff; margin-bottom: 5px;">
                {{ session('success') }}
            </div>
        @endif
        <div class="shop__left-content">
                <div class="shop_image">
                    <img src="{{ asset($shop->image_url) }}" alt="{{ $shop->name }}" class="shop__img">
                </div>
                <div class="shop__tag">
                    <p>#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
                </div>
                <div class="shop__intro">
                    <p>{{ $shop->intro }}</p>
                </div>
                <a href="{{ route('shop.commentsIndex', $shop) }}" class="create-comment">すべての口コミ情報</a>

            <div class="comments-section">
                <div class="comment-actions">
                    <a href="{{ route('comments.edit', ['shop' => $shop->id, 'comment' => $comment->id]) }}" class="button">口コミを編集</a>
                    <form id="delete-form" action="{{ route('comments.delete', ['shop' => $shop->id, 'comment' => $comment->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="link-button">口コミを削除</button>
                    </form>
                </div>
                @if(request('all'))
                    @foreach($shop->comments as $comment)
                    <div class="comment">
                        <div id="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star" data-value="{{ $i }}" style="color: {{ $i <= old('rating', $comment->rating) ? 'rgb(63, 90, 242);' : 'lightgray' }}">★</span>
                            @endfor
                        </div>
                        <p>{{ $comment->content }}</p>
                    </div>
                    @endforeach
                @else
                    @foreach($shop->comments->take(2) as $comment)
                    <div class="comment">
                        <div id="rating">
                            @for ($i = 1; $i <= 5; $i++)
                            <span class="star" data-value="{{ $i }}" style="color: {{ $i <= old('rating', $comment->rating) ? 'rgb(63, 90, 242);' : 'lightgray' }}">★</span>
                            @endfor
                        </div>
                        <p>{{ $comment->content }}</p>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
            <a href="{{ request()->fullUrlWithQuery(['all' => true]) }}" style="display: block; margin-left: 30px; font-size: 14px; font-weight: bold;">
                この店舗の口コミを全て見る</a>
    </div>

    <div class="shop__right-content">
        <h2>予約</h2>
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <div class="form-group">
                <input type="date" id="booking_date" name="booking_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                <select id="booking_time" name="booking_time"
                style="padding: 5px 10px; border: 1px solid white; border-radius: 5px; box-sizing: border-box;
                height: 30px; font-family: 'Arial', sans-serif; font-size: 14px; line-height: 30px;" required>
                    <option value="">時刻を選択してください</option>
                </select>
                <input type="number" id="number" name="number" min="1" max="50" required>
            </div>
            <div class="booking_confirm">
                <div class="booking_detail">
                    <div class="booking_row">
                        <div class="booking_item booking_label">Shop</div>
                        <div class="booking_item booking_value">{{ $shop->name }}</div>
                    </div>
                    <div class="booking_row">
                        <div class="booking_item booking_label">Date</div>
                        <div class="booking_item booking_value" data-type="date">{{ $bookingData['booking_date'] ?? '未設定' }}</div>
                    </div>
                    <div class="booking_row">
                        <div class="booking_item booking_label">Time</div>
                        <div class="booking_item booking_value" data-type="time">{{ $bookingData['booking_time'] ?? '未設定' }}</div>
                    </div>
                    <div class="booking_row">
                        <div class="booking_item booking_label">Number</div>
                        <div class="booking_item booking_value" data-type="number">{{ $bookingData['number'] ?? '未設定' }}人</div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-booking">予約する</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/detail.js') }}"></script>
@endsection
