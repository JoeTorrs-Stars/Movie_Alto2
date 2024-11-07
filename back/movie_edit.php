<?php

include "../include/connect.php";



if (isset($_GET['editID'])) {
    // Get the movie ID from GET request
    $id = $_GET['editID'];

    // Fetch the movie details from the database
    $query = "SELECT * FROM movies WHERE ID='$id'";
    $result = mysqli_query($conn, $query);

    // Check if the movie exists
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); // Fetch the movie details into the $row array
    } else {
        echo "Movie not found.";
        exit;
    }
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $director = $_POST['director'];
    $year = $_POST['year'];
    $casts = $_POST['casts'];
    $genre = isset($_POST['genre']) ? $_POST['genre'] : [];
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    if (empty($title) || empty($description) || empty($director) || empty($year) || empty($casts) || empty($genre)) {
        $errorMessage = "All fields are required";
        echo $errorMessage;
    } else {
        // Create the genre string for the query
        $genreString = is_array($genre) ? implode(", ", $genre) : $genre;

        // Update the movie details in the database
        $query = "UPDATE movies SET 
                  title='$title', 
                  description='$description', 
                  director='$director', 
                  year='$year', 
                  casts='$casts', 
                  genre='$genreString'". 
                  (!empty($image) ? ", image='$image'" : "") . 
                  " WHERE ID='$id'";

        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        } else {
            if (!empty($image)) {
                move_uploaded_file($tmp_name, "../front/uploads/" . basename($image)); // Move uploaded file
            }
            $successMessage = "Movie updated successfully";
            echo $successMessage;
            header("Location: movie_create.php");
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container mt-5"> 

    <button type="button" class="btn btn-warning" onclick="window.history.back();">Return</button>
    </div>
    <div class="container mt-2">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Movie</h4>
                    </div>
                    <div class="card-body">
                        <form action="movie_edit.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $row['ID']; ?>">

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="<?= $row['title']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="textarea" name="description" id="description" rows="3"class="form-control" value="<?= $row['description']; ?>">
                                
                            </div>

                            <div class="form-group">
                                <label for="director">Director</label>
                                <input type="text" name="director" id="director" class="form-control" value="<?= $row['director']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" name="year" id="year" class="form-control" value="<?= $row['year']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="casts">Casts</label>
                                <input type="text" name="casts" id="casts" class="form-control" value="<?= $row['casts']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <input type="text" name="genre" id="genre" class="form-control" value="<?= $row['genre']; ?>">
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" name="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>