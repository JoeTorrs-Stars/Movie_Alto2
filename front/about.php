<?php 
include "../include/connect.php";

if (!isset($_SESSION['user'])) {
    header("Location: back/user/user_data.php");
    exit();
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

    <style>
        .vertical-line {
            border-left: 5px solid red;
            padding-left: 5px;
            margin-bottom: 20px; 
        }

        .vertical-line h2 {
            margin-bottom: 20px;
        }
        .heading-with-line {
            display: flex;
            align-items: center;
        }

        .heading-with-line h2 {
            margin-left: 10px;
        }
        .footer {
            background-color: #158cba;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include "frontbar.php" ?>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Welcome to Movie Alto</h1>

        <div class="row mt-5">
            <div class="col-md-9">
                <h2 class="text-left mb-4">About Movie Alto</h2>
                <p class="text-left">
                    Movie Alto is a state-of-the-art movie management system designed to bring the magic of cinema to your fingertips.
                    Whether you're a casual viewer or a film aficionado, Movie Magic offers a seamless and immersive experience tailored to your preferences.
                </p>
                <p class="text-left">
                    Our platform allows you to explore a comprehensive database of movies, create watchlists, and receive recommendations based on your viewing habits.
                    With Movie Alto, you'll never miss out on the latest releases or timeless classics.
                </p>
                <br>
                <h2 class="text-left mb-4">Features</h2>
                <p class="text-left">
                    - Comprehensive movie database with detailed information on each title
                    <br> - Personalized recommendations based on your viewing history
                    <br> - User-friendly interface for easy navigation and movie management
                    <br> - Watchlists and favorites tracking
                    <br> - Latest movie releases and reviews
                    <br> - And much more!
                </p>
                <br>
                <h2 class="text-left mb-4">FAQs</h2>
                <p class="text-left">
                    Have a question? Check out our <a href="#">FAQ page</a> for more information on using Movie Alto.
                </p>
            </div>

            <div class="col-md-3">
                <div class="vertical-line">
                    <p>We'd love to hear from you! If you have any questions, feedback, or suggestions, please feel free to reach out to us at JoeDudong@gmail.com or follow us on social media.</p>
                </div>

                <div class="vertical-line">
                    <h2>Contact Us</h2>
                    <p>Email: JoeDudong@gmail.com</p>
                    <p>Phone: 09123456789</p>
                    <p>Address: Pasig City</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="login-email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="login-email" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="login-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="login-password">
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Signup -->
    <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="signup-username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="signup-username">
                        </div>
                        <div class="mb-3">
                            <label for="signup-email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="signup-email" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="signup-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="signup-password">
                        </div>
                        <div class="mb-3">
                            <label for="signup-confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="signup-confirm-password">
                        </div>
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Movie Magic. All rights reserved.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzS1C/kxT1w4nPE/zS0Etn7RsIX61zJ/7MDApPyPbT9g" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuKzHd+tL0g7M1UI2j8XKZDt7rsksQbHh8Rf4FOoj0urcD3e6F5FjN09+kGQf0pA" crossorigin="anonymous"></script>
</body>
</html>