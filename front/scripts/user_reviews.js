document.getElementById('submitReview').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent the default form submission

    const userReview = this.user_review.value;
    const userId = this.user_id.value;

    // Send the review to your backend via AJAX or fetch
    fetch('/add-review', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ user_review: userReview, user_id: userId })
    }).then(response => {
        if (response.ok) {
            // Handle success, e.g., show a message or update the UI
        } else {
            // Handle error
        }
    });
});
