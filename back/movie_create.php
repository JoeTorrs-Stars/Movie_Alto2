<?php include "../include/connect.php";

function genreList()
{

    include "../include/connect.php";
    $query = "SELECT * FROM genres";
    $result = $conn->query($query);


    if (!$result) {
        die("Query failed: " . $conn->error);
    }


    if ($result->num_rows > 0) {
        echo "Genres found: <br>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['genre_title'] . "'>" . $row['genre_title'] . "</option>";
        }
    } else {
        echo "No genres available.";
    }
}

function yearList()
{

    include "../include/connect.php";
    $query = "SELECT * FROM years";
    $result = $conn->query($query);

    if (!$result) {

        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        echo "Years found: <br>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['year'] . "'>" . $row['year'] . "</option>";
        }
    } else {
        echo "No years available.";
    }
}

$error_message = '';
$success_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    $genre = isset($_POST['genre']) ? $_POST['genre'] : [];
    $casts = $_POST['casts'];
    $director = $_POST['director'];
    $description = $_POST['description'];
    $year = $_POST['year'];
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    
    if (empty($title) || empty($genre) || empty($casts) || empty($director) || empty($description) || empty($year) || empty($image)) {
        $errorMessage = "All fields are required";
        echo $errorMessage;
        exit; 
    }

    // Check if a movie with the same title already exists
    $check_rows = mysqli_query($conn, "SELECT * FROM movies WHERE title = '$title'");
     
    if (mysqli_num_rows($check_rows) > 0) {
        $error_message ='
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <h4 class="alert-heading">Warning!</h4>
            <p class="mb-0"> A movie with the same title already exists. Please choose a different title.</p>
        </div>';
        exit; // Exit after displaying the message to stop script execution
    }

    // Process genre if it's an array
    $genreString = is_array($genre) ? implode(" , ", $genre) : $genre;

    // File upload: Move uploaded file to the 'uploads' folder
    $target_file = '../front/uploads/' . basename($image);

    if (move_uploaded_file($tmp_name, $target_file)) {
        // Insert movie details into the database
        $query = "INSERT INTO movies (title, genre, casts, director, description, year, image) 
                  VALUES ('$title', '$genreString', '$casts', '$director', '$description', '$year', '$image')";

        if ($conn->query($query) === TRUE) {
           $success_message = ' <div class="alert alert-dismissible alert-success">
           <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
           <h4 class="alert-heading">Success!</h4>
           <p class="mb-0"> Movie added successfully.</p>
       </div>';
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading the movie image.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Data</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/boostrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php
    include "backbar.php";
    ?>
    <?php 
     if (!empty($successMessage)) {
        echo $successMessage;
    }
    
    ?>
    <div class="container justify-content-center mt-3">
        <div class="mb-2">
            <button type="button" class="btn btn-primary mt-3 mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Add Movie
            </button>

            <h2>Movie List</h2>
            <hr>
        </div>
        <table class="table table-light table-striped table-hover table-bordered caption-top shadow-lg table-condensed">
            <br>
            <thead style='text-align: center; vertical-align: middle;'>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Director</th>
                    <th scope="col">Year</th>
                    <th scope="col">Casts</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>

                <?php
                //read all row from database table
                $sql = "SELECT * FROM movies";
                $result = $conn->query($sql);

                $count = 1;

                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td style='text-align: center; vertical-align: middle;'> <?= $count++; ?> </td>
                        <td style='text-align: center; vertical-align: middle;'><?= $row['title']; ?></td>
                        <td style='text-align: center; vertical-align: middle;'> <?php
                                                                                    $genres = explode(' , ', $row['genre']); // Convert back to array
                                                                                    foreach ($genres as $genre) {
                                                                                        echo '<span class="badge rounded-pill bg-primary">' . htmlspecialchars($genre) . '</span> ';
                                                                                    }
                                                                                    ?></td>
                        <td style='text-align: center; vertical-align: middle;'><?= $row['director']; ?></td>
                        <td style='text-align: center; vertical-align: middle;'><?= $row['year']; ?></td>
                        <td style='text-align: center; vertical-align: middle;'><?= $row['casts']; ?></td>
                        <td style='text-align: center; vertical-align: middle;'><?= $row['description']; ?></td>
                        <td style='text-align: center; vertical-align: middle;'><img src='../front/uploads/<?= $row['image']; ?>' alt='image' width='100' height='auto'></td>

                        <td style='text-align: center; vertical-align: middle;'>
                            <div class='btn-group btn-group '>
                                <a class='btn btn-primary ' href='movie_view.php?viewID=<?= $row['ID']; ?>'>View</a>
                                <a class='btn btn-warning ' href='movie_edit.php?editID=<?= $row['ID']; ?>'>Edit</a>
                                <a class='btn btn-danger ' href='movie_delete.php?deleteID=<?= $row['ID']; ?>' onClick="return confirm('Are you sure you want to Delete this Movie Entry?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php
                }

                $conn->close();
                ?>

            </tbody>
        </table>
    </div>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Movie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="movie_create.php" method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <select class="form-select selectpicker " id="genre" name="genre[]" value="" multiple required>
                                <option selected disabled>Select a Genre</option>
                                <?php
                                genreList();
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="casts" class="form-label">Casts</label>
                            <input type="text" class="form-control" id="casts" name="casts" value="" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" value="" autocomplete="off" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="director" class="form-label">Director</label>
                            <input type="text" class="form-control" id="director" name="director" value="" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <select class="form-select" id="year" name="year" value="" required>
                                <option selected disabled>Movie Year</option>
                                <?php
                                yearList();
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" imgsrc="../front/uploads" value="" autocomplete="off" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Movie</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>


</html>