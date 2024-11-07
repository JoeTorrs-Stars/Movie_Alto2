<?php 
include "../include/connect.php";


if (isset($_GET['id'])) {
    $movie_id = (int)$_GET['id']; // Cast to integer for safety

    // Fetch movie details using a simple query
    $query = "SELECT * FROM movies WHERE ID = $movie_id";
    $result = $conn->query($query);

    // Check if the movie exists
    if ($result && $result->num_rows > 0) {
        $movie = $result->fetch_assoc();
        // Prepare the image source path
        $src = 'uploads/' . htmlspecialchars($movie['image']); // Adjust for your image type
    } else {
        echo "<div class='alert alert-danger'>Movie not found.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger'>Invalid movie ID.</div>";
    exit();
}

// Add to Watchlist Functionality
if (isset($_POST['add_to_watchlist'])) {
    $userId = (int)$_SESSION['user']['ID']; // Cast to integer
    $movieId = (int)$movie['ID']; // Cast to integer

    // Insert movie into watchlist using a simple query
    $insertQuery = "INSERT INTO watchlist (user_id, movie_id) VALUES ($userId, $movieId)";
    if ($conn->query($insertQuery) === TRUE) {
        echo '<div class="alert alert-success">Movie added to watchlist.</div>';
    } else {
        echo '<div class="alert alert-danger">Error adding movie to watchlist: ' . $conn->error . '</div>';
    }
}


$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['title']); ?> - Movie Details</title>
    <link rel="stylesheet" href="front/css/bootstrap.min.css">
    <link rel="stylesheet" href="front/css/styles.css"> <!-- Custom CSS for additional styling -->
</head>
<body>
    <!-- Include the navigation bar -->
    <?php include "frontbar.php"; ?>

    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center">
            <h1><?php echo htmlspecialchars($movie['title']); ?></h1>
            <button type="button" class="btn btn-warning" onclick="window.history.back();">Return</button>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $src; ?>" class="img-fluid" alt="<?php echo htmlspecialchars($movie['title']); ?>" style="width: 350px; height: 500px; object-fit: cover;">
            </div>
            <div class="col-md-8">
                <ul class="list-group">
                    <li class="list-group-item"><strong><?php echo htmlspecialchars($movie['description']); ?></strong></li>
                    <li class="list-group-item"><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></li>
                    <li class="list-group-item"><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></li>
                    <li class="list-group-item"><strong>Year:</strong> <?php echo htmlspecialchars($movie['year']); ?></li>
                    <li class="list-group-item"><strong>Cast:</strong> <?php echo htmlspecialchars($movie['casts']); ?></li>
                </ul>
                <form method="POST" class="mt-3">
                    <a href='user_review.php?reviewid=<?= $movie['ID']; ?>' class='btn btn-warning'>User Review</a>
                </form>
            </div>
        </div>
    </div>

    <footer class="text-light footer text-center py-1">
        <hr>
        <p>&copy; <?php echo date("Y"); ?> Movie Magic. All rights reserved.</p>
        <a href="front/.about.php">About Us</a> | 
        <a href="contact.php">FaQ</a>
    </footer>

    <script src="front/js/bootstrap.bundle.min.js"></script> <!-- Include Bootstrap JS -->
</body>
</html>
