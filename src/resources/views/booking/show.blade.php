@extends('layouts.app')

@section('css')
<style>
    body {
        margin: 15px;
        text-align: center ;
    }

    p {
        margin-top: 50px;
        font-size: 20px;
        font-weight: bold;
        line-height: 3px;
    }
</style>
@endsection

@section('content')
    <h1 class="booking-detail" style="font-size: 30px; font-weight: bold;">ご予約詳細</h1>

    <p>お客様名：{{ $booking->user->name }}&nbsp;様</p>
    <p>ご利用店：{{ $booking->shop->name }}</p>
    <p>ご予約日：{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y年m月d日') }}</p>
    <p>お時間　：{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</p>
    <p>人数　　：{{ $booking->number }}&nbsp;名</p>
@endsection