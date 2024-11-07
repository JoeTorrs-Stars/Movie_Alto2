<?php

include "../include/connect.php";
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Sanitize the input to prevent SQL injection
$query = $conn->real_escape_string($query);

// Prepare the SQL statement
$sql = "SELECT * FROM movies WHERE title LIKE '%$query%' OR description LIKE '%$query%' OR genre LIKE '%$query%' OR director LIKE '%$query%'";

// Execute the query
$result = $conn->query($sql);

// Prepare response
if ($result) {
    if ($result->num_rows > 0) {
        // Loop through the results
        while ($row = $result->fetch_assoc()) {
            echo '<div class="list-group-item">';
            echo '<h5>' . htmlspecialchars($row['title']) . '</h5>';
            echo '<p>' . htmlspecialchars($row['description']) . '</p>';
            echo '<small>' . htmlspecialchars($row['director']) . ', ' . htmlspecialchars($row['year']) . '</small>';
            echo '</div>';
        }
    } else {
        echo '<p>No results found.</p>';
    }
} else {
    echo '<p>Error executing query: ' . htmlspecialchars($connection->error) . '</p>';
}




?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Live Search Movies</h2>
        <input type="text" id="search" class="form-control" placeholder="Search for a movie...">
        <div id="results" class="mt-3"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('input', function() {
                const query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: 'search.php',
                        method: 'GET',
                        data: { query: query },
                        success: function(data) {
                            $('#results').html(data);
                        },
                        error: function() {
                            $('#results').html('<p>Error fetching results.</p>');
                        }
                    });
                } else {
                    $('#results').html('');
                }
            });
        });
    </script>
</body>

</html>