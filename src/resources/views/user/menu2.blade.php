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
</head>
<body>
    <header>
        <div class="header__left">
            <div class="close-icon" id="closeButton"></div>
        </div>
    </header>

    <main>
        <div class="menu">
            @if (session()->has('menu2-error'))
                <div class="alert alert-danger">
                    {{ session('menu2-error') }}
                </div>
            @endif
    
            <nav class="nav__content">
                <ul class="nav__list">
                    <li class="nav__item"><a class="nav__item-link" href="/">Home</a></li>
                    <li class="nav__item"><a class="nav__item-link" href="/user/register">Registration</a></li>
                    <li class="nav__item"><a class="nav__item-link" href="/user/login">Login</a></li>
                </ul>
            </nav>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const closeButton = document.getElementById('closeButton');

                closeButton.addEventListener('click', function() {
                    window.location.href = '/';
                });
            });
        </script>
    </main>
</body>
</html>