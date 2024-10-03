@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review-form.css') }}">
@endsection

@section('content')
<div class="review-content">
    <h2>レビュー投稿</h2>
    <div class="shop-info">
        <p style="font-size: 16px; margin-right: 10px;">
            <strong>ご利用店 :</strong> {{ $shop_name ?? '不明' }}
        </p>
        <p style="font-size: 16px; margin-right: 10px;">
            <strong>ご利用日 :</strong> {{ $booking_date ?? '不明' }}
        </p> 
    </div>
    <form action="{{ route('review.confirm') }}" method="GET">
        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" required>
        </div>
        
        <div class="form-group">
            <label>評価</label>
            <div id="rating">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            <input type="hidden" name="rating" id="rating-input" required>
        </div>
        
        <div class="form-group">
            <label for="review">レビュー</label>
            <textarea name="review" id="review" rows="5" required></textarea>
        </div>
    
        <div class="button-group">
            <button type="submit" class="btn btn-review">確認する</button>
        </div>
    </form>
</div>

<script>
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating-input');

    let currentRating = 0;

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = parseInt(star.getAttribute('data-value'));

            if (currentRating === value) {
                currentRating = 0;
                ratingInput.value = '';
            } else {
                currentRating = value;
                ratingInput.value = value;
            }

            stars.forEach(s => {
                s.style.color = s.getAttribute('data-value') <= currentRating ? 'gold' : 'lightgray';
            });
        });
    });
</script>
@endsection
