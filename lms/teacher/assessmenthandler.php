<?php
// upload_assess_handler.php

// Include the database conection file
require_once '../../connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $assessTitle = $_POST["title"];
    $assessDescription = $_POST["description"];
    $assessSubject = $_POST["subject"];
    $assessLevel = $_POST["level"];

    // File Upload
    $targetDir = "../../files/"; // Specify the target directory to store the uploaded files
    $targetFilePath = $targetDir . basename($_FILES["attachment"]["name"]); // Get the file path

    // Check if the file is uploaded successfully
    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)) {
        // File uploaded successfully, now insert the assess details into the database
        $sql = "INSERT INTO assessments (title, description, subject, level, file_path) 
                VALUES ('$assessTitle', '$assessDescription', '$assessSubject', '$assessLevel', '$targetFilePath')";

        if ($con->query($sql) === TRUE) {
            // Database insertion successful
            // Redirect back to the list of uploaded assesss
            header("Location: tutassessments.php");
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