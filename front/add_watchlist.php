<?php
include "../include/connect.php"; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID and movie ID from the URL
$user_id = $_SESSION['user']['ID']; // Assuming you're storing user ID in session
$movie_id = $_GET['movie_id']; // Get movie ID from URL

// Check if the user exists
$checkUserQuery = "SELECT * FROM users WHERE ID = $user_id";
$userResult = $conn->query($checkUserQuery);

if ($userResult->num_rows === 0) {
    die("User ID does not exist.");
}

// Check if the movie is already in the watchlist
$query = "SELECT * FROM watchlist WHERE user_id = $user_id AND movie_id = $movie_id";
$result = $conn->query($query);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

if ($result->num_rows === 0) {
    // Add movie to the watchlist
    $insertQuery = "INSERT INTO watchlist (user_id, movie_id) VALUES ($user_id, $movie_id)";
    
    if ($conn->query($insertQuery) === TRUE) {
        // Redirect with success message
        $_SESSION['watchlist_message'] = "Movie added to your watchlist!";
    } else {
        die("Error inserting movie into watchlist: " . $conn->error);
    }
} else {
    // Movie is already in the watchlist
    $_SESSION['watchlist_message'] = "This movie is already in your watchlist!";
}
header("Location: " . $_SERVER['HTTP_REFERER']);
$conn->close();
?>
