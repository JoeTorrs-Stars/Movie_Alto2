<?php

include "../include/connect.php";

if (isset($_GET['deleteID'])) {
    $id = $_GET['deleteID'];

    // Make sure the ID is a valid number to prevent SQL injection
    $id = intval($id);

    // Prepare the DELETE query
    $sql = "DELETE FROM review_rate WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {

        
    } else {
        echo "Error deleting review: " . $conn->error;
    }
} else {
    echo "No review ID provided to delete.";
}
