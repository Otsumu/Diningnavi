<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @yield('css')
</head>
<body>
    <header>
        <div class= header>
            <div class="header__left">
                <div class="header__icon">
                    <input id="drawer__input" class="drawer__hidden" type="checkbox">
                    <label for="drawer__input" class="drawer__open menuToggle" id="menuToggle">
                    <span></span></label>
                </div>
                <div class="header__logo">Rese</div>
            </div>
            <div class="header__right">
                @yield('header')
            </div>
    </header>

    <main>
        @yield('content')
        @yield('js')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>