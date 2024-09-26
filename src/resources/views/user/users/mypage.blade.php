@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    @if(Auth::check())
        <div class="mypage-title">{{ Auth::user()->name }}さん</div>
    @endif

    <div class="mypage__content">

        <div class="left-content">
            <h3 class="booking-title">予約状況</h3>
            @if (session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif
            @if($bookings->isEmpty())
                <p style="font-size: 16px; padding: 5px;">現在ご予約はありません</p>
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
                                <div class="booking_item booking_value" data-type="time">
                                    {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') ?? '未設定' }}</div>
                            </div>
                            <div class="booking_row">
                                <div class="booking_item booking_label">Number</div>
                                <div class="booking_item booking_value" data-type="number">{{ $booking->number ?? '未設定' }}人</div>
                            </div>
                            <div class="booking_actions">
                                @if(\Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($booking->booking_date . ' ' . $booking->booking_time)))
                                    <a href="{{ route('review.create', $booking->id) }}" class="btn btn-secondary"
                                        style="background-color: #b8f79f; border: 1px solid #b8f79f; ">レビューを書く</a>
                                @else
                                    <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-primary">変更</a>
                                <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">キャンセル</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        <div class="right-content">
            <h3 class="favorites-title">お気に入り店舗</h3>
            @if($favorites->isEmpty())
                <p style="font-size: 16px; padding: 5px;">お気に入り登録店はありません</p>
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
                                    <a href="/detail/{{ $shop->id }}" class="btn btn-details">詳しくみる</a>
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
    
        <div class="review-content">
            <h3 class="reviews-title">レビュー一覧</h3>
        
            @if(session('success-review'))
                <div class="alert alert-success">
                    {{ session('success-review') }}
                </div>
            @endif

            <div class="review__list">
                @foreach($reviews as $review)
                    <div class="review__content">
                        <table class="review-table">
                            <tr>
                                <td class="shop-text">Shop</td>
                                <td class="shop-name">{{ $review->booking->shop->name }}</td>
                            </tr>
                            <tr>
                                <td class="booking-date">Date</td>
                                <td class="booking-date-value">{{ $review->booking->booking_date }}</td>
                            </tr>
                            <tr>
                                <td class="review__rating">Rating</td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <span class="star filled">★</span>
                                        @else
                                            <span class="star">☆</span>
                                        @endif
                                    @endfor
                                </td>
                            </tr>
                            <tr>
                                <td class="title-text">Title</td>
                                <td>{{ $review->title }}</td>
                            </tr>
                            <tr>
                                <td class="review-text">Review</td>
                                <td>{{ $review->review }}</td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.favorite-shop').forEach(button => {
            button.addEventListener('click', function() {
                const shopId = this.getAttribute('data-shop-id');
                const isFavorited = this.getAttribute('data-favorited') === 'true';
            
            if (isFavorited) {
                fetch(`/user/users/mypage/remove/${shopId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (response.ok) {
                        const shopItem = this.closest('.shop__item');
                        shopItem.remove();
                        showMessage('お気に入りから削除しました');
                    }
                });
            }
        });
    });
});
    function showMessage(message) {
        const div = document.createElement('div');
        div.textContent = message;
        div.className = 'alert alert-success';

        div.style.marginTop = '0px';
        div.style.padding = '10px';
        div.style.fontSize = '16px';
        const target = document.querySelector('.favorites-title');
        target.insertAdjacentElement('afterend', div); 

        setTimeout(() => {
            div.remove();
        }, 3000);
    }
</script>
@endsection



