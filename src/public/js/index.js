function changeColor(element) {
    const heartIcon = element.querySelector('.fa-heart');
    const isFavorited = heartIcon.classList.contains('active');
    
    if (isFavorited) {
        heartIcon.classList.remove('active');
        element.setAttribute('data-favorited', 'false');
    } else {
        heartIcon.classList.add('active');
        element.setAttribute('data-favorited', 'true');
    }

    const shopId = element.getAttribute('data-shop-id');
    const url = isFavorited ? `/user/users/mypage/remove/${shopId}` : `/user/users/mypage/add/${shopId}`;
    const method = isFavorited ? 'DELETE' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Failed to update favorite status.');
        }
    })
    .catch(error => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    const areaSelect = document.querySelector('select[name="area"]');
    const genreSelect = document.querySelector('select[name="genre"]');
    const form = document.querySelector('form');

    if (areaSelect) {
        areaSelect.addEventListener('change', function() {
            form.submit();
        });
    }

    if (genreSelect) {
        genreSelect.addEventListener('change', function() {
            form.submit();
        });
    }
});