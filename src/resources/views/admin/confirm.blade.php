@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<main>
  <form class="auth-form" action="{{ route('admin.confirm') }}" method="post">
  @csrf
  <div class="auth-item" style="margin-top: 50px;">
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
          <input type="password" id="password" name="password" value="{{ $data['password'] }}" readonly>
      </div>

      <div class="button-group">
        <button type="button" class="btn-back" onclick="window.location='{{ route('admin.form') }}';">戻る</button>
        <button class="register-btn" type="submit">登録</button>
      </div>
  </div>
  </form>
</main>
@endsection