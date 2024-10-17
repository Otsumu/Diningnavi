@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<main>
    <h1 class="newsletter-title">{{ $subject }}</h1>
    <p style="margin-top: 20px; font-size: 16px;">特別なイベント、お得なキャンペーンのお知らせを随時配信中！</p>
    <p style="margin-top: 20px;" class="newsletter-body">{{ $body }}</p>
</main>
@endsection