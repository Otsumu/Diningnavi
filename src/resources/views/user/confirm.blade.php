@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<main>
  <form class="auth-form" action="{{ route('user.confirm') }}" method="post">
    @csrf
  <div class="auth-item">
    <h2 class="auth-title">Admin</h2>
      <div class="input-group">
        <i class="fa-solid fa-user"></i>
        <input type="text" id="name" name="name" value="{{ $data['name'] }}" readonly>
      </div>

      <div class="input-group">  
        <i class="fa-solid fa-envelope"></i>
        <input type="email" id="email" name="email" value="{{ $data['email'] }}" readonly>
      </div>
      
      <div class="input-group">  
        <i class="fa-solid fa-lock"></i>
        <input type="password" id="password" name="password" placeholder="Password" readonly>
      </div>
      
      <button class="register-btn" type="submit">登録</button>
      <a href="{{ route('user.register') }}" class="back-btn">戻る</a>
    </div>
  </form>
</main>
@endsection