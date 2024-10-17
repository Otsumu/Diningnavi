@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review-form.css') }}">
@endsection

@section('content')
<div class="review-content">
    <h2>レビュー投稿</h2>
    <p class="edit-message" style="text-align: center; font-size: 20px; font-weight: bold;">内容を変更しますか？</p>
    <div class="shop-info">
        <p style="font-size: 16px; margin-right: 10px;">
            <strong>ご利用店 :</strong> {{ $shop_name ?? '不明' }}
        </p>
        <p style="font-size: 16px; margin-right: 10px;">
            <strong>ご利用日 :</strong> {{ $booking_date ?? '不明' }}
        </p> 
    </div>
    <form action="{{ route('review.update', $review->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <input type="hidden" name="booking_id" value="{{ $review->booking->id }}">
        
        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title', $review->title) }}" required>
        </div>
        
        <div class="form-group">
            <label>評価</label>
            <div id="rating">
                @for ($i = 1; $i <= 5; $i++)
                <span class="star" data-value="{{ $i }}" style="color: {{ $i <= old('rating', $review->rating) ? 'gold' : 'lightgray' }}">★</span>
                @endfor
            </div>
            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', $review->rating) }}" required>
        </div>
        
        <div class="form-group">
            <label for="review">レビュー</label>
            <textarea name="review" id="review" rows="5" required>{{ old('review',$review->review) }}</textarea>
        </div>
    
        <div class="button-group">
            <a href="{{ url()->previous() }}" class="btn btn-secondary border-secondary">戻る</a>
            <button type="submit" class="btn btn-review">更新する</button>
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
    stars.forEach(star => {
        if (parseInt(star.getAttribute('data-value')) <= currentRating) {
            star.style.color = 'gold';
        }
    });
</script>
@endsection
