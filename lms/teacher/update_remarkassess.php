<?php
// update_remark.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database connection file
    require_once '../../connection.php';

    // Get the submission ID and the new remark from the form data
    $submissionId = $_POST['submission_id'];
    $remark = $_POST['remark'];

    // Update the remark in the 'actsubmit' table
    $sql = "UPDATE assesssubmit SET remarks = '$remark' WHERE id = '$submissionId'";

    if ($con->query($sql) === TRUE) {
        // Remark updated successfully
        // Get the activity ID from the 'actsubmit' table to include in the redirect URL
        $submissionSql = "SELECT assessid FROM assesssubmit WHERE id = '$submissionId'";
        $submissionResult = $con->query($submissionSql);
        $submission = $submissionResult->fetch_assoc();

        // Redirect back to the submission bin page with the activity_id parameter
        header("Location: submissionbinassess.php?assessid=" . $submission['assessid']);
        exit();
    } else {
        // Error updating the remark
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    // Close the database connection
    $con->close();
}
?>
