<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session
}

if (isset($_SESSION['email'])) {
    if ($_SESSION['type'] == 'admin') {
        header('Location: ./dashboards/admin_dashboard.php'); // Redirect to admin dashboard page
    } else if ($_SESSION['type'] == 'teacher') {
        header('Location: ./dashboards/teacher_dashboard.php'); // Redirect to teacher dashboard page
    } else {
        header('Location: ./dashboards/dashboard.php'); // Redirect to student dashboard page
    }
    exit();
}

require 'connection.php';
$header = 'Login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password1 = $_POST['password'];

    // Check if the login attempts session variable exists
    if (!isset($_SESSION['loginAttempts'])) {
        $_SESSION['loginAttempts'] = 5; // Set initial login attempts to 5
    }

    // Check if the login attempts limit is reached
    if ($_SESSION['loginAttempts'] > 0) {
        // Query to check if the user exists in the database
        $query = "SELECT * FROM tbladmin WHERE email = '$email'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password1, $user['password'])) {
                $_SESSION['email'] = $user['email'];
                $_SESSION['level'] = $user['level'];
                $_SESSION['type'] = $user['type'];

                if ($user['type'] == 'admin') {
                    header('Location: ./dashboards/admin_dashboard.php'); // Redirect to admin dashboard page
                } else if ($user['type'] == 'teacher') {
                    header('Location: ./dashboards/teacher_dashboard.php'); // Redirect to teacher dashboard page
                } else {
                    header('Location: ./dashboards/dashboard.php'); // Redirect to student dashboard page
                }
            }
        } else {
            $error = "Invalid username or password";
            $_SESSION['loginAttempts']--; // Decrement the login attempts

            if ($_SESSION['loginAttempts'] == 0) {
                $_SESSION['waitTime'] = time() + 30; // Set wait time to 30 seconds
            }
        }
    } else {
        if (isset($_SESSION['waitTime']) && $_SESSION['waitTime'] > time()) {
            $error = "Please wait 30 seconds before trying again.";
        } else {
            $_SESSION['loginAttempts'] = 5; // Reset login attempts to 5
            unset($_SESSION['waitTime']); // Reset the wait time
        }
    }

    // Store the login attempts and wait time in JavaScript variables for updating the countdown
    echo "<script>var remainingAttempts = " . $_SESSION['loginAttempts'] . ";</script>";
    if (isset($_SESSION['waitTime'])) {
        echo "<script>var waitTime = " . ($_SESSION['waitTime'] - time()) . ";</script>";
    }
}

require 'views/login.view.php';
