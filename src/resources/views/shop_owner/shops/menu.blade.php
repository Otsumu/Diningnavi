<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/shop_owner-menu.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('css')
</head>
<body>
    <main>
    <div class="menu">
        <div class="menu-title"><strong>{{ Auth::user()->name }}さん</strong>管理ページ</div>
            <nav class="nav__content">
                <ul class="nav__list" style="margin: 0; padding: 0;">
                    <li class="nav__item">
                        <a class="nav__item-link" href="/shop_owner/shops/bookings">Booking List</a>
                    </li>
                    <li class="nav__item">
                        <input type="checkbox" id="shop-operation-toggle" class="nav__toggle">
                        <label for="shop-operation-toggle" class="nav__item-link">Shop Operations</label>
                        <ul class="nav__sub-list">
                            <p>▼ メニューを選択して下さい</p>
                            <li class="nav__sub-item">
                                <a class="nav__sub-item-link" style="text-decoration: none;" href="/shop_owner/shops/form">Create 新規店舗登録</a>
                            </li>
                            <li class="nav__sub-item">
                                <a class="nav__sub-item-link" style="text-decoration: none;" href="/shop_owner/shops/index">ShopList 登録店一覧</a>
                            </li>
                            <li class="nav__sub-item">
                                <a class="nav__sub-item-link" style="text-decoration: none;" href="{{ route('emails.user_send_mail') }}">SendMail メール送信</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav__item">
                        <form action="{{ route('shop_owner.logout') }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="nav__item-link nav__item-link-button">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </main>
</body>
</html>

