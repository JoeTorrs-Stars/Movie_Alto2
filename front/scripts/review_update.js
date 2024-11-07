 // Script to populate edit review modal with existing values
 const editReviewModal = document.getElementById('editReviewModal');
 editReviewModal.addEventListener('show.bs.modal', function (event) {
     const button = event.relatedTarget;
     const reviewId = button.getAttribute('data-reviewid');
     const reviewText = button.getAttribute('data-review');
     const ratingValue = button.getAttribute('data-rating');

     // Populate the modal with existing review data
     document.getElementById('review_id').value = reviewId;
     document.getElementById('editReview').value = reviewText;
     document.querySelector(`input[name="rating"][value="${ratingValue}"]`).checked = true; // Set the radio button
 });