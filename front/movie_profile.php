<?php
include "../include/connect.php";


if (isset($_GET['reviewid'])) {
    $movie_id = $_GET['reviewid'];
} else {
    die("Movie ID is not set.");
}

$movie_query = "SELECT * FROM movies WHERE ID = $movie_id";
$movie_result = $conn->query($movie_query);

if ($movie_result) {
    $movie = $movie_result->fetch_assoc();
    if ($movie) {
       
    } else {
        die("No movie found with ID: " . $movie_id);
    }
} else {
    die("Query failed: " . $conn->error);
}


$review_query = "SELECT * FROM review_rate WHERE movie_id = $movie_id ORDER BY ID DESC";
$reviews_result = $conn->query($review_query); // Define $reviews_result


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['username']; 
        $rating = $_POST['rating'];
        $review = $_POST['review'];
        

        $insert_query = "INSERT INTO review_rate (user_id, user_name, movie_id, reviews, ratings) VALUES ('$user_id', '$user_name', '$movie_id', '$review', '$rating')";

        if ($conn->query($insert_query) === TRUE) {
            echo "Review submitted successfully!";
            header("Location: movie_profile.php?reviewid=" . $movie_id);
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "You must be logged in to submit a review.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo htmlspecialchars($movie['title']); ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/starscript.css">
</head>

<body>
    <?php include "frontbar.php"; ?>
    
    <!-- Display Movie Information -->
    <h1><?php echo htmlspecialchars($movie['title']); ?></h1>
    <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($movie['description']); ?></p>
    <p><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></p>
    <p><strong>Year:</strong> <?php echo htmlspecialchars($movie['year']); ?></p>
    <img src='uploads/<?php echo htmlspecialchars($movie['image']); ?>' alt="Movie Image" />

    <!-- Display Reviews -->
     <br>
     <div class="container justify-content-center mt-3">
    <button type="button" class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#submitReviewModal">
                    Submit Your Review <i class="bi bi-star-fill mr-2"></i>
                </button>
    </div>
    <div class="container justify-content-center mt-4">
    <div class="row">
        <h2>Reviews:</h2> 
        <div class="card">
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                <?php if ($reviews_result && $reviews_result->num_rows > 0): ?>
                    <?php while ($review = $reviews_result->fetch_assoc()): ?>
                        <div class="card bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">User: <?php echo htmlspecialchars($review['user_name']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Rating: <?php echo htmlspecialchars($review['ratings']); ?>/5</h6>
                                <p class="card-text"><?php echo htmlspecialchars($review['reviews']); ?></p>
                            </div>
                            <div class="card-footer text-muted">
                                <small>Posted on: <?php echo htmlspecialchars($review['created_at']); ?></small>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">No reviews yet. Be the first to review!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>


    
    <!-- Button to trigger modal -->
    <div class="row mt-4 justify-content-center">
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="col-auto">
            </div>
        <?php else: ?>
            <p>You must be logged in to submit a review.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal for review submission -->
<!-- <div class="modal fade" id="submitReviewModal" tabindex="-1" aria-labelledby="submitReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitReviewModalLabel">Submit Your Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="movie_profile.php?reviewid=<?php echo $movie_id; ?>" method="POST">
                    <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating (1-5):</label>
                        <input type="number" name="rating" min="1" max="5" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="review" class="form-label">Review:</label>
                        <textarea name="review" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
</div> -->

<div class="modal fade" id="submitReviewModal" tabindex="-1" aria-labelledby="submitReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitReviewModalLabel">Submit Your Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="movie_profile.php?reviewid=<?php echo $movie_id; ?>" method="POST">
                    <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                    <!-- Star Rating -->
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating (1-5):</label>
                        <div class="star-rating d-flex">
                            <span class="star" data-value="1"></span>
                            <span class="star" data-value="2"></span>
                            <span class="star" data-value="3"></span>
                            <span class="star" data-value="4"></span>
                            <span class="star" data-value="5"></span>
                        </div>
                        <input type="hidden" id="rating" name="rating" value="0" required>
                    </div>

                    <div class="mb-3">
                        <label for="review" class="form-label">Review:</label>
                        <textarea name="review" class="form-control" rows="3" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
</div>




<script src="scripts/star_script.js"></script>

<!-- Bootstrap 5 JS and Popper.js -->


</body>

</html>