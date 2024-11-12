@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="shop__content">
    <div class="shop__left-content">
        <div class="shop__detail">
            <a href="{{ $backRoute }}" class="page-back"></a>
            <span class="shop-name">{{ $shop->name }}</span>
        </div>
        <div class="shop_image">
            <img src="{{ asset($shop->image_url) }}" alt="{{ $shop->name }}" class="shop__img">
        </div>
        <div class="shop__tag">
            <p>#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
        </div>
        <div class="shop__intro">
            <p>{{ $shop->intro }}</p>
        </div>
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
                    </div> <!-- ここに閉じタグを追加 -->
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
