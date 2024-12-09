<?php
// Include the database connection file
require_once '../connection.php';

// Function to delete records from both tables based on matching id and assessid
function deleteRecords($id)
{
    global $con;

    // Perform the deletion query for assess table
    $assessSql = "DELETE FROM assessments WHERE id = ?";
    $assessStmt = $con->prepare($assessSql);
    $assessStmt->bind_param("i", $id);

    // Perform the deletion query for assesssubmit table based on matching assessid
    $assesssubmitSql = "DELETE FROM assesssubmit WHERE assessid = ?";
    $assesssubmitStmt = $con->prepare($assesssubmitSql);
    $assesssubmitStmt->bind_param("i", $id);

    // Execute deletion queries
    $assessDeleted = $assessStmt->execute();
    $assesssubmitDeleted = $assesssubmitStmt->execute();

    // Check if both deletions were successful
    if ($assessDeleted && $assesssubmitDeleted) {
        return true; // Deletion successful
    } else {
        return false; // Deletion failed
    }
}

// Check if the delete form is submitted
if (isset($_POST['delete'])) {
    $id = $_POST['record_id']; // Assuming the id to be deleted is passed via a form field named 'record_id'

    if (deleteRecords($id)) {
        // Deletion successful, redirect back to the page
        header('Location: ../lms/teacher/tutassessments.php');
        exit();
    } else {
        // Deletion failed, display an error message or handle it accordingly
        echo "Error deleting record.";
    }
}
?>
