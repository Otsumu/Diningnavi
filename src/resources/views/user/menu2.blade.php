@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">
@endsection

@section('content')
  <div class="menu">
    <nav class="nav__content">
        <ul class="nav__list">
            <li class="nav__item" ><a class="nav__item-link" href="/">Home</a></li>
            <li class="nav__item"><a class="nav__item-link" href="/user/register">Registration</a></li>
            <li class="nav__item"><a class="nav__item-link" href="/user/login">Login</a></li>
        </ul>
    </nav>
</div>
@endsection

