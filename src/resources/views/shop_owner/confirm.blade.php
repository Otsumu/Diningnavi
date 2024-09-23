@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<main>
  <form class="auth-form" action="{{ route('shop_owner.store')  }}" method="post">
    @csrf
  <div class="auth-item">
    <h2 class="auth-title">Admin</h2>
    <p class="confirm-message">この内容で登録してよろしいですか？</p>
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
      
      <div class="button-group">
          <a href="{{ route('shop_owner.register') }}" class="btn-back">戻る</a>
          <button class="register-btn" type="submit">登録</button>
      </div> 
  </div>
  </form>
</main>
@endsection