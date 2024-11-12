@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<main>
    <form class="auth-form" action="{{ route('shop_owner.login') }}" method="post">
        @csrf
        <div class="auth-item">
            <h2 class="auth-title">ShopOwner Login</h2>
            @if (session('message'))
            <div style="padding: 15px; margin-bottom: 20px; font-size: 16px;">
                {{ session('message') }}
            </div>
            @endif
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