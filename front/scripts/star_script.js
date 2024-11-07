document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll('.star-rating .star');
    const ratingInput = document.getElementById('rating');
    let ratingValue = 0;

    stars.forEach((star) => {
        star.addEventListener('mouseover', function () {
            let currentRating = this.getAttribute('data-value');
            highlightStars(currentRating);
        });

        star.addEventListener('mouseout', function () {
            highlightStars(ratingValue);
        });

        star.addEventListener('click', function () {
            ratingValue = this.getAttribute('data-value');
            ratingInput.value = ratingValue;
            console.log("Rating selected (JS):", ratingValue); // Debug: Check rating on click
            highlightStars(ratingValue);
        });
    });

    function highlightStars(rating) {
        stars.forEach((star) => {
            if (parseFloat(star.getAttribute('data-value')) <= parseFloat(rating)) {
                star.classList.add('selected');
            } else {
                star.classList.remove('selected');
            }
        });
    }
});
