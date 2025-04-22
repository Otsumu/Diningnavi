document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const drawerInput = document.getElementById('drawer__input');

    if(!menuToggle) {
        console.error('お探しのメニューが見つかりません');
    }
    if(!drawerInput) {
        console.error('お探しのメニューが見つかりません');
    }

    menuToggle.addEventListener('click',function() {
        const isLoggedIn = drawerInput.checked;
        console.log('メニューがクリックされました ログイン状態：isLoggedIn');
        window.location.href = isLoggedIn ? '/user/users/menu1':'/user/menu2';
    })
});