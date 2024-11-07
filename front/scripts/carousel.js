function scrollCarousel(direction) {
    const carousel = document.getElementById('movieCarousel');
    const scrollAmount = 300; // Scroll by 300px
    if (direction === 1) {
        carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    } else {
        carousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    }
}

// Automatic sliding logic
function autoScrollCarousel() {
    const carousel = document.getElementById('movieCarousel');
    const maxScrollLeft = carousel.scrollWidth - carousel.clientWidth;

    // Slowly scrolls the carousel to the right
    setInterval(() => {
        if (carousel.scrollLeft < maxScrollLeft) {
            carousel.scrollBy({ left: 1, behavior: 'smooth' });
        } else {
            carousel.scrollLeft = 0; // Reset to the start when it reaches the end
        }
    }, 50); // Adjust the interval (50ms) for slower or faster movement
}

// Start the automatic scrolling when the page loads
window.onload = function() {
    autoScrollCarousel();
};