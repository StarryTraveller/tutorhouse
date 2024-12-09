<?php
// upload_activityhandler.php

// Include the database conection file
require_once '../../connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $activitytitle = $_POST["title"];
    $activitydescription = $_POST["description"];
    $activitysubject = $_POST["subject"];
    $activitylevel = $_POST["level"];

    // File Upload
    $targetDir = "../../files/"; // Specify the target directory to store the uploaded files
    $targetFilePath = $targetDir . basename($_FILES["attachment"]["name"]); // Get the file path

    // Check if the file is uploaded successfully
    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)) {
        // File uploaded successfully, now insert the activitydetails into the database
        $sql = "INSERT INTO activities (title, description, subject, level, file_path) 
                VALUES ('$activitytitle', '$activitydescription', '$activitysubject','$activitylevel', '$targetFilePath')";

        if ($con->query($sql) === TRUE) {
            // Database insertion successful
            // Redirect back to the list of uploaded activities
            header("Location: tutactivities.php");
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