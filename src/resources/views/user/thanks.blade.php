@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<main>
    <form class="auth-form" action="{{ route('user.login') }}" method="get">
      <div class="auth-item">
        <h2 class="thanks-message">会員登録ありがとうございます</h2>
        <button class="login-btn" type="submit">ログインする</button>
      </div>
    </form>
</main>
@endsection