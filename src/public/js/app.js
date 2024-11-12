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