@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

<style>
.reminder {
    margin-bottom: 20px;
}
    
.reminder p {
    margin-top: 15px;
    font-size: 20px;
}
</style>

@section('content')
<main>
    <h1 class="reminder">{{ $subject }}</h1>
    <p><strong>{{ $booking->user->name }}様</strong>、本日ご予約当日です。</p>
    <p><strong>{{ $booking->booking_time}}</strong>のご来店をスタッフ一同、心よりお待ち申し上げております！！</p>
</main>
@endsection