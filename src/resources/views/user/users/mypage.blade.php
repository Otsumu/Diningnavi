@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
   <main>
    @if(Auth::check())
        <div class="mypage-title">{{ Auth::user()->name }}さん</div>
    @endif
    <div class="mypage__content">
        <div class="left-content">
            <h3 class="booking-title">予約状況</h3>
            @if($bookings->isEmpty())
                <p>現在ご予約はありません。</p>
            @else
                @foreach($bookings as $booking)
                    <div class="booking_confirm">
                        <h4><i class="fa-regular fa-clock"></i> 予約{{ $loop->iteration }}</h4>
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
                        </div>
                        
                    @endforeach
                @endif
            </div>
        </div>
        <div class="right-content">
            <h3 class="favorites-title">お気に入り店舗</h3>
            @if($favorites->isEmpty())
              <p>お気に入り登録店はありません。</p>
            @else
                <ul>
                 @foreach($favorites as $favorite)
                    <li>
                        <span>{{ $favorite->shop->name }}</span>
                        <form action="{{ route('favorite.remove', $favorite->id) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                            <button type="submit" class="btn btn-remove">削除</button>
                        </form>
                    </li>
                @endforeach
                </ul>
            @endif
        </div>
    </div>
    </main>
@endsection
