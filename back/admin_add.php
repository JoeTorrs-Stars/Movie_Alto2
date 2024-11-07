<?php

include "../include/connect.php";

if ($_SESSION['user']['acctype'] !== 'superadmin') {
    $_SESSION['warning'] = "You do not have the privilege to enter this section.";
    header("Location: index.php"); // Redirect to the dashboard or another page
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $acctype = $_POST['acctype'];

    if (empty($username) || empty($email) || empty($password) || empty($acctype)) {
        $errorMessage = "All fields are required";
        echo $errorMessage;
        exit;
    }

    // Check if user already exists
    $check_rows = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email' OR username = '$username'");
    if (mysqli_num_rows($check_rows) > 0) {
        $error_message = '
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <h4 class="alert-heading">Warning!</h4>
            <p class="mb-0"> A user with the same email or username already exists. Please choose a different email or username.</p>
        </div>';
        echo $error_message;
    } else {
        // Proceed with insertion
        $query = "INSERT INTO admin (username, email, password, acctype) VALUES ('$username', '$email', '$password', '$acctype')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $successMessage = "User added successfully";
            echo $successMessage;
        } else {
            $errorMessage = "Failed to add user: " . mysqli_error($conn);
            echo $errorMessage;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Create</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/boostrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
        <?php include "backbar.php"; ?>

    <div class="container justify-content-center mt-3">
        <div class="mb-2">
            <button type="button" class="btn btn-primary mt-3 mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Create Admin
            </button>

            <h2>Admin List</h2>
            <hr>
        </div>
        <table class="table table-light table-striped table-hover table-bordered caption-top shadow-lg table-condensed">
            <br>
            <thead style='text-align: center; vertical-align: middle;'>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scipe="col">Admin Type</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>

                <?php
                //read all row from database table
                $sql = "SELECT * FROM admin";
                $result = $conn->query($sql);

                $count = 1;

                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td style='text-align: center; vertical-align: middle;'> <?= $count++; ?> </td>
                        <td style='text-align: center; vertical-align: middle;'><?= $row['username']; ?></td>
                        <td style='text-align: center; vertical-align: middle;'><?= $row['email']; ?></td>
                        <td style='text-align: center; vertical-align: middle;'><?= $row['acctype']; ?></td>
                        <td style='text-align: center; vertical-align: middle;'>
                            <div class='btn-group btn-group '>
                                <!-- <a class='btn btn-warning ' href='admin_edit.php?editID=<?= $row['ID']; ?>'>Edit</a> -->
                                <a class='btn btn-danger ' href='admin_delete.php?deleteID=<?= $row['ID']; ?>' onClick="return confirm('Are you sure you want to Delete this Admin?')">Delete</a>
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

    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="admin_add.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required value="" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required value="" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required value="" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="acctype" class="form-label">Account Type</label>
                            <select class="form-select" id="acctype" name="acctype" required value="" autocomplete="off">
                                <option selected disabled>Account Type</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Admin</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

</html>