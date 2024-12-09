<?php
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $announcement_id = $_POST['announcement_id'];
    // You can also validate the $announcement_id here if needed
    // ...

    // Delete announcement from the database
    $query = "DELETE FROM announcements WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $announcement_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Deletion successful
        // Redirect the user to the announcement list page or display a success message
        header("Location: ../views/announcementlist.php");
        exit();
    } else {
        // Handle the case when the deletion fails
        echo 'Error deleting announcement: ' . mysqli_error($con);
    }
    mysqli_stmt_close($stmt);
} else {
    // Handle the case when the request method is not POST
    echo 'Invalid request method.';
}
?>
