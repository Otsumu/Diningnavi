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