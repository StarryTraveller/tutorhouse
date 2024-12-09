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
$school = '';
$level = '';
$parentname = '';
$parentaddress = '';
$parentnumber = '';
$password1 = '';

// Fetch data from the database
if ($con) {
    if (isset($_GET['id'])){
        $id = $_GET['id'];
    $query = "SELECT * FROM tblstudentinfo WHERE id= '$id'";
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
        $school = $row['school'];
        $level = $row['level'];
        $parentname = $row['parentname'];
        $parentaddress = $row['parentaddress'];
        $parentnumber = $row['parentnumber'];
        $password1 = $row['password'];
    }
}
}
require '../views/personalinfo.view.php';