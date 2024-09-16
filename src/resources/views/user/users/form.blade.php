@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
    <div class="booking-update-form">
        <div class="booking__left-content">
            <h2 class="booking-change">ご予約の変更</h2>
            <form action="{{ route('booking.update', $booking->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="shop_id" value="{{ $booking->shop_id }}">
                <div class="form-group">
                    <span class="shop-name">{{ $shop->name }}</span>
                    <div class="shop_image">
                        <img src="{{ asset($shop->image_url) }}" alt="{{ $shop->name }}" class="shop__img">
                    </div>
                    <input type="date" id="booking_date" name="booking_date" value="{{ $booking->booking_date }}" required>
                    <input type="time" id="booking_time" name="booking_time" value="{{ $booking->booking_time }}" required>
                    <input type="number" id="number" name="number" value="{{ $booking->number }}" min="1" max="100" required>
                </div>
        </div>

        <div class="booking__right-content">
            <div class="booking_confirm">
                <div class="booking_detail">
                    <div class="booking_row">
                        <div class="booking_item booking_label">Shop</div>
                        <div class="booking_item booking_value">{{ $shop->name }}</div>
                    </div>
                    <div class="booking_row">
                        <div class="booking_item booking_label">Date</div>
                        <div class="booking_item booking_value" data-type="date">{{ $booking->booking_date ?? '未設定' }}</div>
                    </div>
                    <div class="booking_row">
                        <div class="booking_item booking_label">Time</div>
                        <div class="booking_item booking_value" data-type="time">{{ $booking->booking_time ?? '未設定' }}</div>
                    </div>
                    <div class="booking_row">
                        <div class="booking_item booking_label">Number</div>
                        <div class="booking_item booking_value" data-type="number">{{ $booking->number ?? '未設定' }}</div>
                    </div>
                </div>
                <div class="change-comment">
                    <p>上記の内容に変更でお間違えなければ<br>「変更する」ボタンを押してください</p>
                </div>
                <button type="submit" class="btn-booking">変更する</button>  
            </div>
        </div>
    </form>
    </div>    
@endsection

@section('js')
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