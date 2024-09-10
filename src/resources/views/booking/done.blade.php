@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<main>
    <form class="auth-form" action="{{ route('home') }}" method="get">
      <div class="auth-item">
        <h2 class="thanks-message">ご予約ありがとうございます</h2>
        <button class="back-btn" type="submit">戻る</button>
      </div>
    </form>
</main>
@endsection