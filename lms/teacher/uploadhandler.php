<?php
// upload_lesson_handler.php
session_start();
if (!isset($_SESSION['email']) || ($_SESSION['type'] !== 'teacher' && $_SESSION['type'] !== 'admin')) {
    header("Location: ../login.php");
    exit();
}
// Include the database conection file
require_once '../../connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $lessonTitle = $_POST["title"];
    $lessonDescription = $_POST["description"];
    $lessonSubject = $_POST["subject"];
    $lessonLevel = $_POST["level"];

    // File Upload
    $targetDir = "../../files/"; // Specify the target directory to store the uploaded files
    $targetFilePath = $targetDir . basename($_FILES["attachment"]["name"]); // Get the file path

    // Check if the file is uploaded successfully
    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)) {
        // File uploaded successfully, now insert the lesson details into the database
        $sql = "INSERT INTO lessons (title, description, subject, level, file_path) 
                VALUES ('$lessonTitle', '$lessonDescription', '$lessonSubject', '$lessonLevel', '$targetFilePath')";

        if ($con->query($sql) === TRUE) {
            // Database insertion successful
            // Redirect back to the list of uploaded lessons
            header("Location: tutlessons.php");
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