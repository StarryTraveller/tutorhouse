<?php
// actsubmit.php

// Include the database connection file
require_once '../../connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // File Upload
    $targetDir = "../../submit/"; // Specify the target directory to store the uploaded files
    $targetFilePath = $targetDir . basename($_FILES["attachment"]["name"]); // Get the file path

    // Check if the file is uploaded successfully
    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)) {
        // File uploaded successfully, now insert the activity details into the database

        // Get the activity details (title, subject, and level) from the 'activities' table based on the activity ID
        $activityId = $_POST['activity_id'];
        $activitySql = "SELECT id, title, subject, level FROM activities WHERE id = '$activityId'";
        $activityResult = $con->query($activitySql);
        $activity = $activityResult->fetch_assoc();

        // Get the last name of the student based on the email from the session
        session_start();
        $studentEmail = $_SESSION['email'];
        $studentSql = "SELECT lastname FROM tblstudentinfo WHERE email = '$studentEmail'";
        $studentResult = $con->query($studentSql);
        $student = $studentResult->fetch_assoc();

        // Insert the activity details along with the student's last name into the 'actsubmit' table
        $sql = "INSERT INTO actsubmit (activityid, file_path, name, subject, level, studname) 
                VALUES ('{$activity['id']}', '$targetFilePath', '{$activity['title']}', '{$activity['subject']}', '{$activity['level']}', '{$student['lastname']}')";

        if ($con->query($sql) === TRUE) {
            // Database insertion successful
            // Redirect back to the list of uploaded activities
            header("Location: ./studactivities.php");
            exit();
        } else {
            // Database insertion failed
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        // File upload failed
        echo "Error uploading file.";
    }
}

$con->close();
?>
