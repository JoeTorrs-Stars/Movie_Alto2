    <?php 

include "../include/connect.php";



if (isset($_POST['Regsubmit'])) {
    
    // Sanitize and validate input
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $contact = $_POST['contact'];
    
    

    // Check if email already exists
    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE Email = '$email'");

    if (mysqli_num_rows($check_email) > 0) {
        echo "
            <div class='alert alert-dismissible alert-warning'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <p class='mb-0'>Email Already Exists</p>
            </div>      
        ";
    } else {
        
        if ($password === $confirm_password) {
            $sql = "INSERT INTO users (Name, Username, Email, Password, Contact) VALUES ('$name', '$username', '$email', '$password', '$contact')";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['username'] = $username;
                header("Location: ./index.php");
                exit(); // Make sure to exit after redirection
            } else {
                echo "<div class='alert alert-dismissible alert-warning'>
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        <p class='mb-0'>Error during registration: " . mysqli_error($conn) . "</p>
                      </div>";
            }
        } else {
            echo "<div class='alert alert-dismissible alert-warning'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <p class='mb-0'>Passwords do not match</p>
                  </div>";
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
</head>
<body>
    
</body>
</html>