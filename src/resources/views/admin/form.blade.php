@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<main>
  <form class="auth-form" action="{{ route('admin.register.store') }}" method="post">
  @csrf
  <div class="auth-item" style="margin-top: 50px;">
      <h2 class="auth-title">ShopOwner Registration</h2>
      <div class="input-group">
          <i class="fa-solid fa-user"></i>
          <input type="text" id="name" name="name" placeholder="Username" value="{{ old('name') }}">
      </div>
      <div class="error-message">
          @error('name')
          <p class="auth-form__error-message">{{ $message }}</p>
          @enderror
      </div>

      <div class="error-message">
          @error('shopname')
          <p class="auth-form__error-message">{{ $message }}</p>
          @enderror
      </div>
    
      <div class="input-group">
          <i class="fa-solid fa-envelope"></i>
          <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
      </div>  
      <div class="error-message">
          @error('email')
          <p class="auth-form__error-message">{{ $message }}</p>
          @enderror
      </div>

      <div class="input-group">
          <i class="fa-solid fa-lock"></i>
          <input type="password" id="password" name="password" placeholder="Password">
      </div>
      <div class="error-message">
          @error('password')
          <p class="auth-form__error-message">{{ $message }}</p>
          @enderror
      </div>

      <button class="register-admin-btn" type="submit">確認</button>
    </div>
  </form>
</main>
@endsection