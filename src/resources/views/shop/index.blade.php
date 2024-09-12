@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
<form class="header__right" action="/" method="get">
    <div class="header__search">
      <div class="select-box">
        <label class="select-box-label"></label>
            <select name="area" class="select-box-item">
                <option value="">All area</option>
                    @if(isset($areas))
                      @foreach($areas as $area)
                      <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                      {{ $area->name }}</option>
                      @endforeach
                    @endif
            </select>
        </div>

        <div class="select-box">
        <label class="select-box-label"></label>
            <select name="genre" class="select-box-item">
                <option value="">All genre</option>
                @if(isset($genres))
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </label>
      </div>

      <div class="search__item">
        <div class="search__item-button">  
          <i class="fa-solid fa-magnifying-glass"></i></div>
          <label class="search__item-label">
            <input type="text" name="keyword" class="search__item-input" placeholder="Search ..." value="{{ request('keyword') }}">
          </label>
      </div>
    </div>
</form>
@endsection

@section('content')
<div class="homepage">
  @if (session('success'))
    <div style="background-color: #cce5ff; color: #004085; padding: 7px; font-size: 12px; border-radius: 5px; 
    border: 1px solid #b8daff; margin-bottom: 5px;">
        {{ session('success') }}
    </div>
  @endif
    <div class="shop__list">
      @foreach($shops as $shop)
      <div class="shop__item">
        <div class="shop__image">
          <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}" class="shop__img">
        </div>
        <div class="shop__content">
          <h2>{{ $shop->name }}</h2>
          <p>#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
          <div class="shop__buttons">
            <a href="/detail/{{ $shop->id }}">詳しくみる</a>
            <button class="favorite-shop" type="button">
            <i class="fa-solid fa-heart"></i>
            </button>
          </div>  
        </div>
      </div>
      @endforeach
    </div>
</div>
@endsection
