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

$id = $_GET['updateid'];
$sql = "SELECT * FROM `tblstudentinfo` WHERE id = $id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
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

    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

    $sql = "UPDATE `tblstudentinfo` SET lastname='$lastname', firstname='$firstname', middlename='$middlename', suffix='$suffix', address='$address', barangay='$barangay', city='$city', email='$email', phone='$phone', birthdate='$birthdate', age='$age', gender='$gender', school='$school', level='$level', parentname='$parentname', parentaddress='$parentaddress', parentnumber='$parentnumber', password='$hashed_password' WHERE id=$id";

    $result = mysqli_query($con, $sql);
    if ($result) {
        // Update successful

        // Update tbladmin table
        $sql = "UPDATE `tbladmin` SET email='$email', password='$hashed_password', level='$level' WHERE email='$email'";

        $result = mysqli_query($con, $sql);

        if ($result) {
            // Update successful
            header('location: ../studentinfo/studentlist.php');
            exit();
        } else {
            die(mysqli_error($con));
        }
    } else {
        die(mysqli_error($con));
    }
}

require '../views/updateinfo.view.php';
