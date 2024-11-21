@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/commentsIndex.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1 class="title">全ての口コミ</h1>
        <form method="GET" action="{{ url()->current() }}">
            <div class="sort-options">
                <label for="sort">並び替え:</label>
                <select id="sort" name="sort" onchange="this.form.submit()">
                    <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>新しい順</option>
                    <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>古い順</option>
                    <option value="highest_rating" {{ $sort == 'highest_rating' ? 'selected' : '' }}>評価が高い順</option>
                    <option value="lowest_rating" {{ $sort == 'lowest_rating' ? 'selected' : '' }}>評価が低い順</option>
                </select>
            </div>
        </form>
        @foreach ($comments as $comment)
            <div class="comment">
                <p><strong>投稿日: </strong>{{ ($comment->created_at->format('Y年m月d日')) }}
                <p><strong>ご利用店: </strong>{{ $comment->shop->name }} <a href="/detail/{{ $comment->shop->id }}" class="btn btn-details">店舗詳細</a>
                <p><img src="{{ asset($comment->image_url ?? $comment->shop->image_url ) }}" alt="{{ $comment->shop->name }}" class="shop__img"></p>
                <p id="rating"><strong>評価:</strong>
                        @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}" style="color: {{ $i <= old('rating', $comment->rating) ? 'rgb(63, 90, 242);' : 'lightgray' }}">★</span>
                        @endfor
                </p>
                <p><strong>口コミ内容: </strong>{{ $comment->content }}</p>
            </div>
        @endforeach
        </div>
        @if ($comments->hasPages())
            <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $comments->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $comments->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>

                @foreach ($comments->links()->elements as $element)
                    @if (is_string($element))
                        <li class="disabled page-item"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li class="page-item {{ $page == $comments->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                    @endif
                @endforeach

                <li class="page-item {{ $comments->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $comments->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            </ul>
            </nav>
        @endif
@endsection