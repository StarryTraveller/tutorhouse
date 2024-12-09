<?php
// Include the database connection file
require_once '../connection.php';

// Function to delete records from both tables based on matching id and activityid
function deleteRecords($id)
{
    global $con;

    // Perform the deletion query for activities table
    $activitiesSql = "DELETE FROM activities WHERE id = ?";
    $activitiesStmt = $con->prepare($activitiesSql);
    $activitiesStmt->bind_param("i", $id);

    // Perform the deletion query for actsubmit table based on matching activityid
    $actsubmitSql = "DELETE FROM actsubmit WHERE activityid = ?";
    $actsubmitStmt = $con->prepare($actsubmitSql);
    $actsubmitStmt->bind_param("i", $id);

    // Execute deletion queries
    $activitiesDeleted = $activitiesStmt->execute();
    $actsubmitDeleted = $actsubmitStmt->execute();

    // Check if both deletions were successful
    if ($activitiesDeleted && $actsubmitDeleted) {
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
        header('Location: ../lms/teacher/tutactivities.php');
        exit();
    } else {
        // Deletion failed, display an error message or handle it accordingly
        echo "Error deleting record.";
    }
}
?>
