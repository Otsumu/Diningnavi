@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
<link rel="stylesheet" href="{{ asset('css/reminder.css') }}">
@endsection

@section('content')
<main>
    <h1 class="reminder">{{ $subject }}</h1>
    <p><strong>{{ $booking->user->name }}様</strong>、本日ご予約当日です。</p>
    <p><strong>{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</strong>にスタッフ一同、ご来店を心よりお待ち申し上げております！！</p>
</main>
@endsection