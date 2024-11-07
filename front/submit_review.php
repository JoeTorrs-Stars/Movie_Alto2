<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $movie_id = $_POST['movie_id'];
    $user_name = $_POST['user_name'];
    $user_rating = $_POST['user_rating'];
    $user_review = $_POST['user_review'];
    $datetime = time(); // Get the current time

    // Insert the review into the review_table
    $query = "INSERT INTO review_table (movie_id, user_name, user_rating, user_review, datetime) 
              VALUES ('$movie_id', '$user_name', '$user_rating', '$user_review', '$datetime')";
              
    if ($conn->query($query)) {
        echo "Review submitted successfully!";
        header("Location: movie_details.php?movie_id=" . $movie_id); // Redirect back to movie details page
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

?>