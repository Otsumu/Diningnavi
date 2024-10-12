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
<style>
    .pagination {
        font-size: 18px;
        margin-top: 20px;
    }
    .pagination .page-item {
        margin: 0 5px;
    }
    .pagination .page-link {
        padding: 10px 15px;
        font-weight: bold;
    }
    .pagination .page-link:hover {
        background-color: #f0f0f0;
    }
    .pagination .active .page-link {
        background-color: rgb(63, 90, 242);
        color: white;
        border-color: rgb(63, 90, 242);
    }
</style>
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
<script>
    function changeColor(element) {
        const heartIcon = element.querySelector('.fa-heart');
        const isFavorited = heartIcon.classList.contains('active');
        
        if (isFavorited) {
            heartIcon.classList.remove('active');
            element.setAttribute('data-favorited', 'false');
        } else {
            heartIcon.classList.add('active');
            element.setAttribute('data-favorited', 'true');
        }
  
        const shopId = element.getAttribute('data-shop-id');
        const url = isFavorited ? `/user/users/mypage/remove/${shopId}` : `/user/users/mypage/add/${shopId}`;
        const method = isFavorited ? 'DELETE' : 'POST';
  
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Failed to update favorite status.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const areaSelect = document.querySelector('select[name="area"]');
        const genreSelect = document.querySelector('select[name="genre"]');
        const form = document.querySelector('form');

        if (areaSelect) {
            areaSelect.addEventListener('change', function() {
                form.submit();
            });
        }

        if (genreSelect) {
            genreSelect.addEventListener('change', function() {
                form.submit();
            });
        }
    });
  </script>
@endsection