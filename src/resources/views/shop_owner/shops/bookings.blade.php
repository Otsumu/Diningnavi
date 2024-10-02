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
    <h2 class="page-title">Booking List</h2>

    <a href="{{ route('shop_owner.shops.menu') }}" class="page-back">戻る</a>

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
                <th><i class="fa-solid fa-shop"></i>&nbsp;Shop</th>
                <th><i class="fa-regular fa-clock"></i></i>&nbsp;Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->user->email }}</td>
                    <td>{{ $booking->shop->name }}</td>
                    <td>{{ $booking->booking_date }}&nbsp;{{ $booking->booking_time }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($bookings->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $bookings->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $bookings->previousPageUrl() }}" rel="prev">&laquo;</a>
            </li>

            @foreach ($bookings->links()->elements as $element)
                @if (is_string($element))
                    <li class="disabled page-item"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="page-item {{ $page == $bookings->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                @endif
            @endforeach

            <li class="page-item {{ $bookings->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $bookings->nextPageUrl() }}" rel="next">&raquo;</a>
            </li>
        </ul>
    </nav>
    @endif
    </div>
</main>
</html>