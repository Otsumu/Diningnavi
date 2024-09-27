@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<main>
    <form class="auth-form" action="{{ route('admin.login') }}" method="post">
        @csrf
        @if (session('success'))
            <div style="background-color: #cce5ff; color: #004085; padding: 7px; font-size: 12px; border-radius: 5px; border: 1px solid #b8daff; margin-bottom: 5px;">
                {{ session('success') }}
            </div>
        @endif
        <div class="auth-item">
            <h2 class="auth-title">Admin Login</h2>
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
            <button class="login-btn" type="submit">ログイン</button>
        </div>
    </form>
</main>
@endsection