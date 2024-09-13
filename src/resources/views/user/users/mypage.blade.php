@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    @if(Auth::check())
        <div class="mypage-title">{{ Auth::user()->name }}さん</div>
    @endif

    <div class="mypage__content">
        <!-- 予約状況 -->
        <div class="left-content">
            <h3 class="booking-title">予約状況</h3>
            @if($bookings->isEmpty())
                <p>現在ご予約はありません。</p>
            @else
                @foreach($bookings as $booking)
                    <div class="booking_confirm">
                        <h4><i class="fa-regular fa-clock"></i>予約{{ $loop->iteration }}</h4>
                        <div class="booking_detail">
                            <div class="booking_row">
                                <div class="booking_item booking_label">Shop</div>
                                <div class="booking_item booking_value">{{ $booking->shop->name }}</div>
                            </div>
                            <div class="booking_row">
                                <div class="booking_item booking_label">Date</div>
                                <div class="booking_item booking_value" data-type="date">{{ $booking->booking_date ?? '未設定' }}</div>
                            </div>
                            <div class="booking_row">
                                <div class="booking_item booking_label">Time</div>
                                <div class="booking_item booking_value" data-type="time">{{ $booking->booking_time ?? '未設定' }}</div>
                            </div>
                            <div class="booking_row">
                                <div class="booking_item booking_label">Number</div>
                                <div class="booking_item booking_value" data-type="number">{{ $booking->number ?? '未設定' }}人</div>
                            </div>
                            <div class="booking_actions">
                                <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-primary">予約の変更</a>
                                <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">予約のキャンセル</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        <!-- お気に入り店舗 -->
        <div class="right-content">
            <h3 class="favorites-title">お気に入り店舗</h3>
            @if($favorites->isEmpty())
                <p>お気に入り登録店はありません。</p>
            @else
                <div class="shop__list">
                    @foreach($favorites as $shop)
                        <div class="shop__item">
                            <div class="shop__image">
                                <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}" class="shop__img">
                            </div>
                            <div class="shop__content">
                                <h2>{{ $shop->name }}</h2>
                                <p>#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
                                <div class="shop__buttons">
                                    <a href="{{ route('shop.show', $shop->id) }}" class="btn btn-details">詳しくみる</a>
                                    <button class="favorite-shop" type="button" data-shop-id="{{ $shop->id }}" data-favorited="true">
                                        <i class="fa-solid fa-heart heart-icon active"></i>
                                    </button>
                                </div>  
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.favorite-shop').forEach(function(button) {
                button.addEventListener('click', function() {
                    const shopId = this.getAttribute('data-shop-id');
                    const isFavorited = this.getAttribute('data-favorited') === 'true';
                    const url = isFavorited ? `/favorite/remove/${shopId}` : `/favorite/add/${shopId}`;
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
                        if (data.success) {
                            const heartIcon = this.querySelector('.heart-icon');
                            if (isFavorited) {
                                heartIcon.classList.remove('active');
                                this.setAttribute('data-favorited', 'false');
                            } else {
                                heartIcon.classList.add('active');
                                this.setAttribute('data-favorited', 'true');
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection



