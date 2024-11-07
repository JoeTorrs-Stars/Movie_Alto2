<?php

include "../include/connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/boostrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php include "backbar.php"; ?>

    <div class="container justify-content-center mt-3">
        <table class="table table-light table-striped table-hover table-bordered caption-top shadow-lg table-condensed">
            <thead style='text-align: center; vertical-align: middle;'>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Email</th>
                    <th scipe="col">Profile Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //read all row from database table
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);

                $count = 1;

                while ($row = $result->fetch_assoc()) {
                ?>

                    <tr>
                        <td style='text-align: center; vertical-align: middle;'> <?= $count++; ?> </td>
                        <td style='text-align: center; vertical-align: middle;'> <?= $row['name'] ?> </td>
                        <td style='text-align: center; vertical-align: middle;'> <?= $row['username'] ?> </td>|
                        <td style='text-align: center; vertical-align: middle;'> <?= $row['contact'] ?> </td>
                        <td style='text-align: center; vertical-align: middle;'> <?= $row['email'] ?> </td>
                        <td style='text-align: center; vertical-align: middle;'>
                            <img src="../front/uploads/<?= $row['profile_image'] ?>" alt="image" style="width: 100px; height: auto;">
                        </td>



                        <td style='text-align: center; vertical-align: middle;'>
                            <div class='btn-group btn-group '>
                                <a class='btn btn-danger ' href='genre_delete.php?deleteID=<?= $row['ID']; ?>' onClick="return confirm('Are you sure you want to Delete this Genre Entry?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php
                }

                $conn->close();
                ?>
            </tbody>


    </div>
</body>

</html>