<?php 

include "../include/connect.php";

$user = $_SESSION['user'];

$query = "
    SELECT * FROM movies
    WHERE genre IN (
        SELECT genre FROM movies
        WHERE id IN (
            SELECT movie_id FROM watchlist WHERE user_id = $user_id
        )
    )
    AND id NOT IN (
        SELECT movie_id FROM watchlist WHERE user_id = $user_id
    ) LIMIT 5";

$result = mysqli_query($conn, $query);

// Display the recommended movies
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div>" . $row['title'] . " - " . $row['genre'] . "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>