<?php
require '../connection.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // Get email from tblstudentinfo
    $emailQuery = "SELECT email FROM `tblstudentinfo` WHERE id=$id";
    $emailResult = mysqli_query($con, $emailQuery);

    if ($emailResult && mysqli_num_rows($emailResult) > 0) {
        $row = mysqli_fetch_assoc($emailResult);
        $email = $row['email'];

        // Delete from tblstudentinfo
        $deleteStudentQuery = "DELETE FROM `tblstudentinfo` WHERE id=$id";
        $deleteStudentResult = mysqli_query($con, $deleteStudentQuery);

        if ($deleteStudentResult) {
            // Delete from tbladmin
            $deleteAdminQuery = "DELETE FROM `tbladmin` WHERE email='$email'";
            $deleteAdminResult = mysqli_query($con, $deleteAdminQuery);

            // Delete from assess using lastname
            $deleteAssessQuery = "DELETE FROM `assess` WHERE studentid='$id'";
            $deleteAssessResult = mysqli_query($con, $deleteAssessQuery);

            if ($deleteAdminResult && $deleteAssessResult) {
                // Data deleted successfully
                header('Location: ../studentinfo/studentlist.php');
                exit();
            } else {
                die(mysqli_error($con));
            }
        } else {
            die(mysqli_error($con));
        }
    } else {
        die("Email not found for the given ID.");
    }
}
