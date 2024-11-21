@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
<form class="header__right" action="/" method="get">
    <div class="header__center__search">
        <div class="select-box select-box-sort">
            <label class="select-box-label">並び替え：</label>
            <select name="sort" class="select-box-item" style="margin: 0; padding-top: 13px;" onchange="this.form.submit()">
                <option value="random" {{ request('sort') == 'random' ? 'selected' : '' }}>ランダム</option>
                <option value="high_rating" {{ request('sort') == 'high_rating' ? 'selected' : '' }}>評価が高い順</option>
                <option value="low_rating" {{ request('sort') == 'low_rating' ? 'selected' : '' }}>評価は低い順</option>
            </select>
        </div>
    </div>

    <div class="header__search">
        <div class="select-box">
            <label class="select-box-label"></label>
            <select name="area" class="select-box-item">
                <option value="">All Areas</option>
                    @if(isset($areas))
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
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
        </div>

        <div class="search__item">
            <div class="search__item-button">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <label for="search-keyword">
                <input type="text" id="search-keyword" name="keyword" class="search__item-input" placeholder="Search ..." value="{{ request('keyword') }}">
            </label>
        </div>
    </div>
</form>
@endsection

@section('content')
<div class="homepage">
    @if (session('success'))
        <div style="background-color: #cce5ff; color: #004085; padding: 7px; font-size: 12px; border-radius: 5px; border: 1px solid #b8daff; margin-bottom: 5px;">
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
                        <a href="/detail/{{ $shop->id }}" class="btn btn-details">詳しくみる</a>
                        <button class="favorite-shop" type="button" data-shop-id="{{ $shop->id }}" data-favorited="{{ $shop->isFavorited ? 'true' : 'false' }}" onclick="changeColor(this)">  
                            <i class="fa-solid fa-heart {{ $shop->isFavorited ? 'active' : '' }} heart-icon"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@if ($shops->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $shops->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $shops->previousPageUrl() }}" rel="prev">&laquo;</a>
            </li>

            @foreach ($shops->links()->elements as $element)
                @if (is_string($element))
                    <li class="disabled page-item"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="page-item {{ $page == $shops->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                @endif
            @endforeach

            <li class="page-item {{ $shops->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $shops->nextPageUrl() }}" rel="next">&raquo;</a>
            </li>
        </ul>
    </nav>
@endif
@endsection

@section('js')
<script src="{{ asset('js/index.js') }}"></script>
@endsection