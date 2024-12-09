<?php
// Include the database connection file
require_once '../connection.php';

// Function to delete a record from the database
function deleteRecord($tableName, $id)
{

    // Perform the deletion query
    global $con;
    $lessons = "lessons";
    $sql = "DELETE FROM $lessons WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return true; // Deletion successful
    } else {
        return false; // Deletion failed
    }
}

// Check if the delete form is submitted
if (isset($_POST['delete'])) {
    $tableName = $_POST['lessons']; 
    $id = $_POST['record_id'];

    if (deleteRecord($tableName, $id)) {
        // Deletion successful, redirect back to the page
        header('Location: ../lms/teacher/tutlessons.php');
        exit();
    } else {
        // Deletion failed, display an error message or handle it accordingly
        echo "Error deleting record.";
    }
}
?>
