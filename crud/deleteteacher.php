<?php
require '../connection.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // Get email from tblstudentinfo
    $emailQuery = "SELECT email FROM `tblteacherinfo` WHERE id=$id";
    $emailResult = mysqli_query($con, $emailQuery);

    if ($emailResult && mysqli_num_rows($emailResult) > 0) {
        $row = mysqli_fetch_assoc($emailResult);
        $email = $row['email'];

        // Delete from tblstudentinfo
        $deleteTeacherQuery = "DELETE FROM `tblteacherinfo` WHERE id=$id";
        $deleteTeacherResult = mysqli_query($con, $deleteTeacherQuery);

        if ($deleteTeacherResult) {
            // Delete from tbladmin
            $deleteAdminQuery = "DELETE FROM `tbladmin` WHERE email='$email'";
            $deleteAdminResult = mysqli_query($con, $deleteAdminQuery);

            if ($deleteAdminResult) {
                // Data deleted successfully
                header('Location: ../studentinfo/teacherlist.php');
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
