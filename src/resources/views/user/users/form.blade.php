@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
    <div class="booking-update-form">
        <div class="booking-header">
            <h2 class="booking-change">ご予約の変更</h2>
        </div>
        <form action="{{ route('booking.update', $booking->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="shop_id" value="{{ $booking->shop_id }}">

            <div class="form-group">
                <img src="{{ asset($shop->image_url) }}" alt="{{ $shop->name }}" class="shop__img">
            </div>

            <div class="form-group">
                <label for="shop_name">Shop</label>
                <span>{{ $shop->name }}</span>
            </div>

            <div class="form-group">
                <label for="booking_date">Date</label>
                <input type="date" id="booking_date" name="booking_date" value="{{ $booking->booking_date }}" required>
            </div>

            <div class="form-group">
                <label for="booking_time">Time</label>
                <input type="time" id="booking_time" name="booking_time" value="{{ $booking->booking_time }}" required>
            </div>

            <div class="form-group">
                <label for="number">Number</label>
                <input type="number" id="number" name="number" value="{{ $booking->number }}" min="1" max="100" required>
            </div>

            <div class="form-group">
                <a href="{{ route('user.users.mypage') }}" class="btn-back">戻る</a>
                <button type="submit" class="btn-booking">変更する</button>
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