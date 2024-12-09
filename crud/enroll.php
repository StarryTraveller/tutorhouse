<?php
session_start(); // Start session

// Prevent caching of the page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Check if the user is logged in
if (!isset($_SESSION['email']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../login.php"); // Redirect to login page if user is not logged in or doesn't have the student role
    exit();
}
require '../connection.php';

if (isset($_POST['submit'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $suffix = $_POST['suffix'];
    $address = $_POST['address'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $email1 = $_POST['email'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $school = $_POST['school'];
    $level = $_POST['level'];
    $parentname = $_POST['parentname'];
    $parentaddress = $_POST['parentaddress'];
    $parentnumber = $_POST['parentnumber'];
    $password1 = $_POST['password'];
    $type = "student";

    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

    // Insert into tblstudentinfo table
    $sql = "INSERT INTO tblstudentinfo (lastname, firstname, middlename, suffix, address, barangay, city, email, phone, birthdate, age, gender, school, level, parentname, parentaddress, parentnumber, password) VALUES ('$lastname', '$firstname', '$middlename', '$suffix', '$address', '$barangay', '$city', '$email', '$phone', '$birthdate', '$age', '$gender', '$school', '$level', '$parentname', '$parentaddress', '$parentnumber', '$hashed_password')";

    $result = mysqli_query($con, $sql);

    if ($result) {
        // Data inserted successfully
        $id = mysqli_insert_id($con);
        // Insert into tbladmin table
        $sql_admin = "INSERT INTO tbladmin (email, password, type, level) VALUES ('$email', '$hashed_password', '$type', '$level')";
        $result_admin = mysqli_query($con, $sql_admin);

        // Insert into assess table
        $sql_assess = "INSERT INTO assess (studentid, lastname) VALUES ('$id', '$lastname')";
        $result_assess = mysqli_query($con, $sql_assess);

        if ($result_admin && $result_assess) {
            // Data inserted successfully in both tables
            header('Location: ../studentinfo/studentlist.php');
            exit();
        } else {
            die(mysqli_error($con));
        }
    } else {
        die(mysqli_error($con));
    }
}

require '../views/enroll.view.php';
