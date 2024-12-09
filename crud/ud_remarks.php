<?php
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['remarks'])) {
        $id = $_POST['id'];
        $remarks = $_POST['remarks'];

        // Use prepared statements to prevent SQL injection
        $updateQuery = "UPDATE `ticket` SET remarks = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "si", $remarks, $id);

        if (mysqli_stmt_execute($stmt)) {
            // Remarks updated successfully, you can redirect back to the page if needed
            header("Location: ../views/ticket.php");
            exit();
        } else {
            // Handle the case when the update fails
            echo "Failed to update remarks: " . mysqli_error($con);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    }
}

// Close the database connection
mysqli_close($con);
?>