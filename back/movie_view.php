<?php

include "../include/connect.php";

if (isset($_GET['viewID'])) {

    $sql = "SELECT * FROM movies WHERE ID = '" . $_GET['viewID'] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/boostrap.min.css">
</head>

<body>
    <?php include "backbar.php"; ?>
    <div class="container text-center mt-5">
        <!-- Movie Title -->
        <h1 class="text-start">Movie Profile</h1>

        <div class="row">
            <!-- Movie Poster Column -->
            <div class="col-md-4">
                <div class="card text-white mb-4 mt-3 p-4">
                    <img src="../front/uploads/<?= $row['image']; ?>" alt="<?= $row['title']; ?>" class="img-fluid" style="width: 100%; height: auto;">
                    <div class="card-body">
                        <a href="movie_create.php" class="btn btn-warning btn-block">Return to List</a>
                    </div>
                </div>
            </div>

            <!-- Movie Details Column -->
            <div class="col-md-5">
                <div class="card text-white bg-info mb-4 mt-3">
                    <div class="card-header"><strong><?= $row['title'] ?> (<?= $row['year'] ?>)</strong></div>
                    <div class="card-body">
                        <!-- Movie Description -->
                        <h4 class="card-title text-start">Description</h4>
                        <p class="card-text text-start"><?= $row['description'] ?></p>
                        <hr>
                        <!-- Additional Information -->
                        <p class="card-text text-start"><strong>Casts:</strong> <?= $row['casts'] ?></p>
                        <p class="card-text text-start"><strong>Director:</strong> <?= $row['director'] ?></p>
                        <p class="card-text text-start"><strong>Genre:</strong> <?php
                                                                                $genres = explode(', ', $row['genre']); // Convert back to array
                                                                                foreach ($genres as $genre) {
                                                                                    echo '<span class="badge rounded-pill bg-warning">' . htmlspecialchars($genre) . '</span> ';
                                                                                }
                                                                                ?></p>
                    </div>
                </div>
            </div>

            <!-- Streaming Platforms Column -->
            <div class="col-md-3">
                <div class="card text-white bg-info mb-4 mt-3">
                    <div class="card-header">Available On</div>
                    <div class="card-body">
                        <h4 class="card-title">Streaming Platforms</h4>
                        <p class="card-text"><a href="#">Netflix</a></p>
                        <p class="card-text"><a href="#">Hulu</a></p>
                        <p class="card-text"><a href="#">Amazon Prime</a></p>
                        <!-- Add more platforms as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>