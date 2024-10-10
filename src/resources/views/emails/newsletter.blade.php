@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<main>
    <h1 class="newsletter-title">{{ $subject }}</h1>
    <p>特別なイベント、お得なキャンペーンのお知らせを随時配信中！<br>
        お楽しみに！！</p>
    <p class="newsletter-body">{{ $body }}</p>
</main>
@endsection