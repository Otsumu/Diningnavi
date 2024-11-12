<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>index</title>
    <link rel="stylesheet" href="{{ asset('css/shop_owner-index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('css')
</head>
<body>
<main>
    <h2 class="page-title">Index</h2>

    @if (session('success'))
        <div style="background-color: #cce5ff; color: #004085; padding: 7px; font-size: 12px; border-radius: 5px; border: 1px solid #b8daff; margin-bottom: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <a href="{{ route('shop_owner.shops.menu') }}" class="page-back">戻る</a>
        <table class="table">
            <thead>
                    <tr>
                        <th><i class="fa-solid fa-shop"></i>&nbsp;shop</th>
                        <th><i class="fa-regular fa-comment"></i>&nbsp;Intro</th>
                        <th><i class="fa-regular fa-image"></i>&nbsp;Image URL</th>
                        <th><i class="fa-solid fa-location-dot"></i>&nbsp;Area</th>
                        <th><i class="fa-solid fa-utensils"></i>&nbsp;Genre</th>
                        <th>actions</th>
                    </tr>
            </thead>
            <tbody>
                @forelse($shops as $shop)
                    <tr>
                        <td>{{ $shop->name }}</td>
                        <td>{{ $shop->intro}}</td>
                        <td>{{ $shop->image_url }}</td>
                        <td>{{ $shop->area->name }}</td>
                        <td>{{ $shop->genre->name }}</td>
                        <td>
                            <form action="{{ route('shop_owner.shops.edit', $shop->id) }}" method="GET" style="display:inline;">
                                <button type="submit" class="btn btn-primary">編集</button>
                            </form>
                            <form action="{{ route('shop_owner.shops.delete', $shop->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('削除してよろしいですか?');">削除</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6">ショップが見つかりませんでした。</td>
                        </tr>
                    @endforelse
            </tbody>
        </table>
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

    </div>
</main>
</html>
