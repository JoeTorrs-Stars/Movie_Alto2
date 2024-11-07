<?php

include "../include/connect.php";

if (isset($_GET['deleteID'])) {

    $id = $_GET['deleteID'];

    $sql = "DELETE FROM admin WHERE id = $id";
    $result = $conn->query($sql);

    if ($result) {
        header("location: index.php");
        exit();
    }
    else {
        echo "<script>alert('Movie Not Deleted')</script>";
    }
}
?>
