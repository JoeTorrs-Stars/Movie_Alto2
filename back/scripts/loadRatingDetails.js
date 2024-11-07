function loadRatingDetails(viewID) {
    $.ajax({
        url: 'rating_view.php', // Adjust path if necessary
        type: 'GET',
        data: { viewID: viewID },
        success: function(data) {
            $('#modalContent').html(data); // Load the returned HTML into the modal content
        },
        error: function(xhr, status, error) {
            console.error("Error loading data:", xhr.responseText); // Log the error
            $('#modalContent').html("<p>Error loading data: " + error + "</p>");
        }
    });
}