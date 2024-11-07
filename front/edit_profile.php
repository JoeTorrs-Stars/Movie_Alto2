<?php

include "../include/connect.php"; // Connect to the database
// Check if user session exists
if (!isset($_SESSION['user'])) {
    header("Location: back/user_data.php");
    exit(); // Stop further execution
}

$user = $_SESSION['user'];

// Query to get the user's current information from the database
$sql = "SELECT bio, profile_image, email, name, contact, password FROM users WHERE username = '" . $user['username'] . "'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $user_data = $result->fetch_assoc();
    $bio = htmlspecialchars($user_data['bio']);
    $profile_image = $user_data['profile_image'];
    $email = htmlspecialchars($user_data['email']);
    $name = htmlspecialchars($user_data['name']);
    $contact = htmlspecialchars($user_data['contact']);
    $password = $user_data['password']; // Get the plain password
} else {
    header("Location: user.php");
    exit();
}

// Set a default profile image if the user does not have one
$profile_image = isset($profile_image) ? 'uploads/' . htmlspecialchars($profile_image) : 'uploads/profile_pics/default_profile.jpg';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_bio = htmlspecialchars($_POST['bio']);
    $new_email = htmlspecialchars($_POST['email']);
    $new_name = htmlspecialchars($_POST['name']);
    $new_contact = htmlspecialchars($_POST['contact']); // Ensure contact is treated as a string
    $new_profile_image = $_FILES['profile_image']['name'];

    // Input validation for contact number (assuming a 10 or 11-digit number)
    if (!preg_match('/^[0-9]{10,11}$/', $new_contact)) {
        $error_message = "Invalid contact number format. Please enter a 10 or 11 digit number.";
    } else {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $error_message = '';

        // Initialize updated_password with the current password
        $updated_password = $password; // Default to the current password

        // If a new password is provided, verify the current password matches
        if (!empty($new_password)) {
            if ($current_password === $password) {
                // Assign the new password
                $updated_password = $new_password;
                echo "Password updated successfully.";
            } else {
                $error_message = "Current password is incorrect.";
            }
        }

        // Handle profile image upload
        // if ($new_profile_image) {
        //     // Check if the image file is uploaded correctly
        //     $target_file = 'uploads/' . basename($new_profile_image);
        //     if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
        //         // Update query to include the new profile image
        //         $profile_image = $new_profile_image;
        //     } else {
        //         $error_message = "Error uploading the profile image.";
        //     }
        // }

        if ($new_profile_image) {
            // Move uploaded file and ensure it doesn't overwrite existing
            $target_file = 'uploads/' . basename($new_profile_image);
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                // Update query to include the new profile image
                $sql = "UPDATE users SET bio = '$new_bio', profile_image = '$new_profile_image', email = '$new_email', name = '$new_name', contact = '$new_contact', password = '$updated_password' WHERE username = '".$user['username']."'";
            } else {
                $error_message = "Error uploading the profile image.";
            }
        } else {
            // Update query without new profile image
            $sql = "UPDATE users SET bio = '$new_bio', email = '$new_email', name = '$new_name', contact = '$new_contact', password = '$updated_password' WHERE username = '".$user['username']."'";
        }
        
        // Execute the update query and check for errors
        if (empty($error_message) && $conn->query($sql) === TRUE) {
            // Update user session data to reflect changes
            $_SESSION['user']['bio'] = $new_bio;
            $_SESSION['user']['email'] = $new_email; // Update email in session
            $_SESSION['user']['name'] = $new_name; // Update name in session
            $_SESSION['user']['contact'] = $new_contact; // Update contact in session
            $_SESSION['user']['profile_image'] = $new_profile_image ? $new_profile_image : $profile_image;
        
            // Profile updated successfully
            header("Location: user.php");
            exit();
        } else {
            // Log or display an error message if needed
            echo "Error updating profile: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../front/css/bootstrap.css">
    <link rel="stylesheet" href="../front/css/bootstrap.min.css">

</head>

<body>
    <!-- Include the navigation bar -->
    <?php include "../front/frontbar.php"; ?>

    <div class="container d-flex justify-content-center align-items-center vh-50 mt-3">
    <div class="card p-2 col-12 col-sm-6 col-md-12 col-lg-6 shadow-sm">

            <h2>Edit Profile</h2>

            <div class="text-center mb-2">
                <img src="<?php echo $profile_image; ?>" alt="Profile Picture" class="rounded-circle" width="150" height="150" value>
            </div>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group mb-2">
                    <label for="profile_image" class="form-label">Profile Image</label>
                    <input type="file" class="form-control-file" id="profile_image" name="profile_image" value="<?php echo $profile_image; ?>">
                    <small class="text-muted">No file chosen</small>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" value="<?php echo $email; ?>" required>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name"  placeholder="Name" value="<?php echo $name; ?>" required>
                    <label for="name">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact" value="<?php echo $contact; ?>" required>
                    <label for="contact">Contact</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="current_password" placeholder="password" name="current_password">
                    <label for="current_password">Current Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="new_password" placeholder="password" name="new_password">
                    <label for="new_password">New Password</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="bio" name="bio" style="height: 100px;"><?php echo $bio; ?></textarea>
                    <label for="bio">Bio</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update Profile</button>
            </form>
        </div>
    </div>

    <script src="../front/js/bootstrap.bundle.min.js"></script>
</body>

</html>