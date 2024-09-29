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
                <select id="booking_time" name="booking_time" 
                style="width: 100%; border: 1px solid lightgray; border-radius: 3px; box-sizing: border-box;
                height: 30px; line-height: 30px; font-size: 12px; padding: 0px 0px 5px;" 
                required></select>
            </div>

            <div class="form-group">
                <label for="number">Number</label>
                <input type="number" id="number" name="number" value="{{ $booking->number }}" min="1" max="50" required>
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

        function generateTimeOptions() {
            for (let hour = 17; hour <= 21; hour++) {
            for (let minute = 0; minute < 60; minute += 30) {
            if (hour === 21 && minute === 30) {
                continue; 
            }
            const timeValue = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
            const option = document.createElement('option');
            option.value = timeValue;
            option.textContent = timeValue;
            bookingTimeInput.appendChild(option);
            }
        }
            const lastOrderOption = document.createElement('option');
            lastOrderOption.value = '21:30';
            lastOrderOption.textContent = '21:30';
            bookingTimeInput.appendChild(lastOrderOption);
        }

        function updateBookingDetails() {
            const bookingDateValue = bookingDateInput.value || '未設定';
            const bookingTimeValue = bookingTimeInput.value || '未設定';
            const numberValue = numberInput.value ? `${numberInput.value}'人` : '未設定';

            console.log(`Date: ${bookingDateValue}, Time: ${bookingTimeValue}, Number: ${numberValue}`);
        }

        generateTimeOptions();
        updateBookingDetails();

        bookingDateInput.addEventListener('input', updateBookingDetails);
        bookingTimeInput.addEventListener('input', updateBookingDetails);
        numberInput.addEventListener('input', updateBookingDetails);
    });
</script>
@endsection