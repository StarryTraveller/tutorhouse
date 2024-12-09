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
        // File uploaded successfully, now insert the assess details into the database

        // Get the assess details (title, subject, and level) from the 'activities' table based on the assess ID
        $assessId = $_POST['assess_id'];
        $assessSql = "SELECT id, title, subject, level FROM assessments WHERE id = '$assessId'";
        $assessResult = $con->query($assessSql);
        $assess = $assessResult->fetch_assoc();

        // Get the last name of the student based on the email from the session
        session_start();
        $studentEmail = $_SESSION['email'];
        $studentSql = "SELECT lastname FROM tblstudentinfo WHERE email = '$studentEmail'";
        $studentResult = $con->query($studentSql);
        $student = $studentResult->fetch_assoc();

        // Insert the assess details along with the student's last name into the 'actsubmit' table
        $sql = "INSERT INTO assesssubmit (assessid, file_path, name, subject, level, studname) 
                VALUES ('{$assess['id']}', '$targetFilePath', '{$assess['title']}', '{$assess['subject']}', '{$assess['level']}', '{$student['lastname']}')";

        if ($con->query($sql) === TRUE) {
            // Database insertion successful
            // Redirect back to the list of uploaded activities
            header("Location: ./studassessments.php");
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
