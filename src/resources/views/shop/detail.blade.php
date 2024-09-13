@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('js')
@section('content')
<div class="shop__content">
    <div class="shop__left-content">
        <div class="shop__detail">
            <a href="{{ $backRoute ?? '' }}" class="page-back"></a>
            <span class="shop-name">{{ $shop->name }}</span>
        </div>
        <div class="shop_image">
            <img src=" {{ asset($shop->image_url) }}" alt="{{ $shop->name }}" class="shop__img">
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
        <form action="{{ route('booking') }}" method="POST">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <div class="form-group">
                <input type="date" id="booking_date" name="booking_date" required>
                <input type="time" id="booking_time" name="booking_time" required>
                <input type="number" id="number" name="number" min="1" max="100" required>
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
                        <div class="booking_item booking_value" data-type="number">{{ $bookingData['number'] ?? '未設定' }}</div>
                    </div>
                </div>
            </div>
                <button type="submit" class="btn btn-booking">予約する</button>
            </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookingDateInput = document.getElementById('booking_date');
        const bookingTimeInput = document.getElementById('booking_time');
        const numberInput = document.getElementById('number');
        
        const bookingDateValue = document.querySelector('.booking_value[data-type="date"]');
        const bookingTimeValue = document.querySelector('.booking_value[data-type="time"]');
        const numberValue = document.querySelector('.booking_value[data-type="number"]');
        
        function updateBookingDetails() {
            bookingDateValue.textContent = bookingDateInput.value || '未設定';
            bookingTimeValue.textContent = bookingTimeInput.value || '未設定';
            numberValue.textContent = numberInput.value || '未設定';
        }
        
        bookingDateInput.addEventListener('input', updateBookingDetails);
        bookingTimeInput.addEventListener('input', updateBookingDetails);
        numberInput.addEventListener('input', updateBookingDetails);
        
        updateBookingDetails();
    });
</script>
@endsection