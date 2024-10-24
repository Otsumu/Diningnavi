<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('css')
</head>
<body>
    <header>
        <div class="header__left">
            <div class="close-icon" id="closeButton"></div>
        </div>
    </header>

<main>
  <div class="menu">
    <nav class="nav__content">
        <ul class="nav__list">
            <li class="nav__item" ><a class="nav__item-link" href="/">Home</a></li>
            <li class="nav__item">
                <form action="{{ route('logout') }}" method="POST" style="display: inline-block;">
                    @csrf
                    <button type="submit" class="nav__item-link nav__item-link-button">
                        Logout
                    </button>
                </form>
            </li>
            <li class="nav__item"><a class="nav__item-link" href="/user/users/mypage">Mypage</a></li>
        </ul>
    </nav>
  </div>
</main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const closeButton = document.getElementById('closeButton');
        const menu = document.querySelector('.nav__content');
        
        if (closeButton && menu) {
            closeButton.addEventListener('click', function() {
                menu.classList.add('hidden');
                window.location.href = '/';
            });
        }
    });
  </script>
</body>
</html>