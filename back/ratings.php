<?php
include "../include/connect.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratings</title>
    <link rel="stylesheet" href="../back/css/bootstrap.css">
    <link rel="stylesheet" href="../back/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php
    include "backbar.php";
    ?>
    <div class="container justify-content-center mt-3">
        <table class="table table-light table-striped table-hover table-bordered caption-top shadow-lg table-condensed">
            <br>
            <thead style='text-align: center; vertical-align: middle;'>
                <tr>
                    <th scope="col">#</th>
                    <!-- <th scope="col">User ID</th> -->
                    <th scope="col">User Name</th>
                    <!-- <th scope="col">Movie ID</th> -->
                    <!-- <th scope="col">Review/Comment</th> -->
                    <th scope="col">Rate</th>
                    <!-- <th scope="col">Time Created</th> -->
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // Read all rows from the database table
                $sql = "SELECT * FROM review_rate";
                $result = $conn->query($sql);

                $count = 1;

                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td style='text-align: center; vertical-align: middle;'> <?= $count++; ?> </td>
                        <!-- <td style='text-align: center; vertical-align: middle;'><?= $row['user_id']; ?></td> -->
                        <td style='text-align: center; vertical-align: middle;'><?= $row['user_name']; ?></td>
                        <!-- <td style='text-align: center; vertical-align: middle;'><?= $row['movie_id']; ?></td> -->
                        <!-- <td style='text-align: center; vertical-align: middle;'><?= $row['reviews']; ?></td> -->
                        <td style='text-align: center; vertical-align: middle;'><?= $row['ratings']; ?></td>
                        <!-- <td style='text-align: center; vertical-align: middle;'><?= $row['created_at']; ?></td> -->

                        <td style='text-align: center; vertical-align: middle;'>
                            <div class='d-flex justify-content-center gap-2'>
                                <!-- Link now points to a separate deletion script -->
                                <button class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="loadRatingDetails(<?= $row['ID']; ?>)">View</button>
                                <a class='btn btn-danger' href='ratings_delete.php?deleteID=<?= $row['ID']; ?>' onClick="return confirm('Are you sure you want to Delete this Movie Entry?')">Delete</a>

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

    <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ratingModalLabel">Rating Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalContent"><?php
                                            ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="scripts/loadRatingDetails.js"></script>

</html>