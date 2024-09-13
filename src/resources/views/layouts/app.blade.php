<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('css')
</head>
<body>
    <header>
        <div class="header__left">
            <div class="header__icon">
                <input id="drawer__input" class="drawer__hidden" type="checkbox">
                <label for="drawer__input" class="drawer__open menuToggle" id="menuToggle">
                <span></span></label>
            </div>
            <div class="header__logo">Rese</div>
        </div>
        @yield('header')
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const drawerInput = document.getElementById('drawer__input');

    if (!menuToggle || !drawerInput) {
        console.error('Menu toggle or drawer input not found.');
        return;
    }

    menuToggle.addEventListener('click', function() {
        console.log('Menu toggle clicked. Checked:', drawerInput.checked);
        if (drawerInput.checked) {
            window.location.href = '/user/users/menu1';
        } else {
            window.location.href = '/user/menu2';
        }
      });  
    });
    </script>
    
    <main>
        @yield('content')
        @yield('js')
    </main>
</body>

</html>