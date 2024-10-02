<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/admin-shopowners.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('css')
</head>
<body>
<main>
    <h2 class="page-title">Shop Owners List</h2>

    <a href="{{ route('admin.menu') }}" class="page-back">戻る</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
    <table class="table">
        <thead>
            <tr>
                <th><i class="fa-solid fa-id-card-clip"></i>&nbsp;ID</th>
                <th><i class="fa-solid fa-user"></i>&nbsp;Name</th>
                <th><i class="fa-solid fa-envelope"></i>&nbsp;Email</th>
                <th><i class="fa-solid fa-shop"></i>&nbsp;Shops Owned</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shopOwners as $shopOwner)
                <tr>
                    <td>{{ $shopOwner->id }}</td>
                    <td>{{ $shopOwner->name }}</td>
                    <td>{{ $shopOwner->email }}</td>
                    <td>
                        @if($shopOwner->shops->isNotEmpty())
                            @foreach($shopOwner->shops as $shop)
                                <a href="{{ route('shop.detail', $shop->id) }}">{{ $shop->name }}</a><br>
                            @endforeach
                        @else
                            <span>登録店舗はありません</span>
                        @endif
                    </td>
                    <td>
                    <form action="{{ route('admin.edit', $shopOwner->id) }}" method="GET" style="display:inline;">
                        <button type="submit" class="btn btn-primary">編集する</button>
                    </form>
                    <form action="{{ route('admin.delete', $shopOwner->id) }}" method="POST" style="display:inline;">

                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('削除してよろしいですか?');">削除する</button>
                    </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($shopOwners->hasPages())
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item {{ $shopOwners->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $shopOwners->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>

                    @foreach ($shopOwners->links()->elements as $element)
                        @if (is_string($element))
                            <li class="disabled page-item"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <li class="page-item {{ $page == $shopOwners->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                        @endif
                    @endforeach

                    <li class="page-item {{ $shopOwners->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $shopOwners->nextPageUrl() }}" rel="next">&raquo;</a>
                    </li>
                </ul>
            </nav>
        @endif

    </div>
</main>
</html>