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
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <div class="form-group">
                <input type="date" id="booking_date" name="booking_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  required>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookingDateInput = document.getElementById('booking_date');
        const bookingTimeInput = document.getElementById('booking_time');
        const numberInput = document.getElementById('number');

        const bookingDateValue = document.querySelector('.booking_value[data-type="date"]');
        const bookingTimeValue = document.querySelector('.booking_value[data-type="time"]');
        const numberValue = document.querySelector('.booking_value[data-type="number"]');

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
            bookingDateValue.textContent = bookingDateInput.value || '未設定';
            bookingTimeValue.textContent = bookingTimeInput.value || '未設定';
            numberValue.textContent = (numberInput.value ? numberInput.value + '人' : '未設定');
        }

        function validateBookingTime() {
            const now = new Date();
            const selectedDate = new Date(bookingDateInput.value);
            const inputTime = bookingTimeInput.value;

            if (!inputTime) return;

            const [hours, minutes] = inputTime.split(':').map(Number);
            const selectedTime = new Date(selectedDate.setHours(hours, minutes));
            
            if (selectedDate.toDateString() === now.toDateString()) {
                const minTime = new Date(now.getTime() + 1 * 60 * 60 * 1000);
                if (selectedTime < minTime) {
                    alert('予約は現時刻から1時間以降に可能です');
                    bookingTimeInput.value = '';
                    return false;
                }
            }
            
            return true;
        }

        bookingDateInput.addEventListener('input', function() {
            updateBookingDetails();
        });

        bookingTimeInput.addEventListener('input', function() {
            if (validateBookingTime()) {
                updateBookingDetails();
            }
        });

        numberInput.addEventListener('input', function() {
            const value = numberInput.value;
            if (value >= 1 && value <= 50) {
                numberInput.value = value;
                updateBookingDetails();
            } else {
                numberInput.value = '';
                updateBookingDetails();
            }
        });

        generateTimeOptions();
        updateBookingDetails();

        numberInput.placeholder = '1人';

        numberInput.addEventListener('focus', () => {
            numberInput.placeholder = '';
        });

        numberInput.addEventListener('blur', () => {
            if (numberInput.value === '') {
                numberInput.placeholder = '1人';
            } else {
                numberInput.placeholder = numberInput.value + '人';
            }
        });

    });
</script>
@endsection