<?php 



do {

    if (empty($title) || empty($genre) || empty($casts) || empty($director) || empty($description) || empty($year) || empty($image)) {
        $errorMessage = "All fields are required";
        echo $errorMessage;
    } 

    if ($check_rows->num_rows > 0) {
        $errorMessage = "Movie already exists";
        break;
    }
    else {
        $query = "INSERT INTO movies (title, genre, casts, director, description, year, image) VALUES ('$title', '$genreString', '$casts', '$director', '$description', '$year', '$image')";
    }



}while (false);



?>