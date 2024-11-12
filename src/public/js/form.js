const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating-input');

    let currentRating = parseInt(ratingInput.value) || 0;

    stars.forEach(star => {
        star.style.color = star.getAttribute('data-value') <= currentRating ? 'gold' : 'lightgray';

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
                s.style.color = s.getAttribute('data-value') <= currentRating ? 'gold' : 'lightgray';
            });
        });
    });