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
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<main>
  <div class="menu">
    <div class="menu-title"><strong><u>{{ Auth::user()->name }}さん</u></strong>こんにちわ！</div>
    <nav class="nav__content">
        <ul class="nav__list" style="margin: 0; padding: 0;">
            <li class="nav__item">
                <a class="nav__item-link" href="/shop_owner/shops/bookings">Booking List</a>
            </li>
            <li class="nav__item">
                <a class="nav__item-link dropdown-toggle" href="#">Shop Operations</a>
                <ul class="nav__sub-list hidden" style="list-style: none;">
                    <p>▼ メニューを選択して下さい</p>
                    <li class="nav__sub-item">
                        <a class="nav__sub-item-link" style="text-decoration: none;" href="/shop_owner/shops/form">Create 新規店舗登録</a>
                    </li>
                    <li class="nav__sub-item">
                        <a class="nav__sub-item-link" style="text-decoration: none;" href="/shop_owner/shops/index">Shop List 登録店一覧</a>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function (event) {
                event.preventDefault();
                const subList = this.nextElementSibling;

                console.log('Dropdown clicked'); 

                if (subList) {
                    subList.classList.toggle('hidden');
                    console.log('Sublist visibility:', !subList.classList.contains('hidden'));
                }
            });
        });
    });
</script>

</body>
</html>
