document.querySelectorAll('#rating .star').forEach(function(star) {
    star.addEventListener('click', function() {
        var ratingValue = this.getAttribute('data-value');

        document.querySelectorAll('#rating .star').forEach(function(star) {
            star.classList.remove('selected');
        });

        document.querySelectorAll('#rating .star').forEach(function(star, index) {
            if (index < ratingValue) {
                star.classList.add('selected');
            }
        });

        document.getElementById('rating-input').value = ratingValue;
    });
});