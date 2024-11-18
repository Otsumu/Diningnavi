const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating-input');

    let currentRating = 0;

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = parseInt(star.getAttribute('data-value'));

            if (currentRating === value) {
                currentRating = 0;
                ratingInput.value = '';
            } else {
                currentRating = value;
                ratingInput.value = value;
            }

            stars.forEach(s => {
                s.style.color = s.getAttribute('data-value') <= currentRating ? 'rgb(63, 90, 242)' : 'lightgray';
            });
        });
    });
    stars.forEach(star => {
        if (parseInt(star.getAttribute('data-value')) <= currentRating) {
            star.style.color = 'rgb(63, 90, 242)';
        }
    });