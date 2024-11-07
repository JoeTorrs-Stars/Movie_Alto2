<?php

include "../include/connect.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['viewID'])) {
    // Sanitize input to prevent SQL Injection
    $viewID = intval($_GET['viewID']); // Assuming ID is an integer
    $sql = "SELECT * FROM review_rate WHERE ID = '$viewID'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Return the relevant rating details
        echo "<h6>Movie ID: " . htmlspecialchars($row['movie_id']) . "</h4>";
        echo "<p>Comment: " . htmlspecialchars($row['reviews']) . "</p>";
    } else {
        echo "<p>No ratings found for this movie.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>