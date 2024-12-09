<?php
session_start(); // Start session

// Prevent caching of the page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Check if the user is logged in


require '../connection.php';

$id = '';
$lastname = '';
$firstname = '';
$middlename = '';
$suffix = '';
$address = '';
$barangay = '';
$city = '';
$email = '';
$phone = '';
$birthdate = '';
$age = '';
$gender = '';
$password1 = '';

// Fetch data from the database
if ($con) {
    $email = $_SESSION['email']; // Assuming email is stored in the session
    $query = "SELECT * FROM tblteacherinfo WHERE email= '$email'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Assign values from the row to variables
        $id = $row['id'];
        $lastname = $row['lastname'];
        $firstname = $row['firstname'];
        $middlename = $row['middlename'];
        $suffix = $row['suffix'];
        $address = $row['address'];
        $barangay = $row['barangay'];
        $city = $row['city'];
        $email = $row['email'];
        $phone = $row['phone'];
        $birthdate = $row['birthdate'];
        $age = $row['age'];
        $gender = $row['gender'];
        $password1 = $row['password'];
    }
}

require '../views/teacherinfo.php';
