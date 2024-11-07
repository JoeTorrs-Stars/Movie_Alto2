<?php 
include "../include/connect.php";

if (!isset($_SESSION['user'])) {
    header("Location: back/user/user_data.php");
}
$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Alto</title>
    <link rel="stylesheet" href="front/css/bootstrap.css">
    <link rel="stylesheet" href="front/css/bootstrap.min.css">
</head>
<body>
    <?php include "frontbar.php" ?>
</body>
</html>