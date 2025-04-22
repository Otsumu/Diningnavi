document.addEventListener('DOMContentLoaded',function() {
    document.querySelectorAll('.favorite-shop').forEach(button => {
        button.addEventListener('click',function() {
            changeColor(button);
        });
    });

    function changeColor(button) {
        const heartIcon = button.querySelector('.fa-heart');
        const isFavorited = heartIcon.classList.contains('active');

        if(isFavorited) {
            heartIcon.classList.remove('active');
            element.setAttribute('data-favorited','false');
        } else {
            heartIcon.classList.add('active');
            element.setAttribute('data-favorited','true');
        }
    }
});

    const shopId = button.getAttribute('data-shop-id');
    const url = isFavorited ? `/user/users/mypage/remove/${shopId}` : `/user/users/mypage/add/${shopId}`;
    const method = isFavorited ? 'DELETE' : 'POST';

    fetch(url, {
        method:'POST',
        headers: {
            'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Context-Type':'application/json'
        },
    })
        .then(response => response.json())
        .then(data => {
            if(!data.success) {
                console.log('データ読み込みに失敗しました');
            }
        })
        .catch(error => console.error("お気に入りの更新に失敗しました"));

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



