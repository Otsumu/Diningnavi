@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<main>
    <form class="auth-form" action="{{ route('admin.update', $shopOwner->id) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="auth-item" style="margin-top: 50px;">
            <h2 class="auth-title">Admin</h2>
            <p class="confirm-message">内容を変更しますか？</p>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" id="name" name="name" value="{{ old('name', $data['name']) }}">
            </div>

            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" id="email" name="email" value="{{ old('email', $data['email']) }}">
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="新しいパスワードを入力（任意）">
            </div>

            <div class="button-group">
                <a href="{{ route('admin.shop_owners') }}" class="btn-back">戻る</a>
                <button class="register-btn" type="submit">変更</button>
            </div>
        </div>
    </form>
</main>
@endsection
