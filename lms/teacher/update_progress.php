<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted and process the data

    // Include the connection to the database
    require_once '../../connection.php';

    // Fetch data from the form
    $lastName = $_POST['lastname'];
    $subject = $_POST['subject'];
    $initial = $_POST['initial'];
    $final = $_POST['final'];
    $status = $_POST['status'];

    // Retrieve values from hidden inputs in progress.php
    $act = $_POST['act'];
    $ass = $_POST['ass'];
    $ave = $_POST['ave'];

    // Prepare the SELECT query to check if the record already exists in the assess table
    $selectQuery = "SELECT * FROM assess WHERE lastname = ? AND subject = ?";
    if ($stmt = mysqli_prepare($con, $selectQuery)) {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ss", $lastName, $subject);

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Store the result
        mysqli_stmt_store_result($stmt);

        // Check if the record exists
        if (mysqli_stmt_num_rows($stmt) > 0) {
            // The record exists, update it
            $updateQuery = "UPDATE assess
                            SET initial = ?, final = ?, status = ?
                            WHERE subject = ? AND lastname = ?";
            if ($updateStmt = mysqli_prepare($con, $updateQuery)) {
                // Bind the parameters to the prepared statement
                mysqli_stmt_bind_param($updateStmt, "sssss", $initial, $final, $status, $subject, $lastName);

                // Execute the prepared statement
                if (mysqli_stmt_execute($updateStmt)) {
                    // Redirect back to the same page to show the updated values
                    header("Location: progress.php?lastname=" . urlencode($lastName) . "&subject=" . urlencode($subject));
                    exit();
                } else {
                    // Handle the case when the query fails
                    echo "Error updating record: " . mysqli_stmt_error($updateStmt);
                }

                // Close the prepared statement
                mysqli_stmt_close($updateStmt);
            } else {
                // Handle the case when the prepared statement fails
                echo "Error preparing update statement: " . mysqli_error($con);
            }
        } else {
            // The record doesn't exist, insert a new record
             // Prepare the INSERT query
    $insertQuery = "INSERT INTO assess (lastname, subject, initial, final, act, ass, ave, status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    if ($insertStmt = mysqli_prepare($con, $insertQuery)) {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($insertStmt, "ssssssss", $lastName, $subject, $initial, $final, $act, $ass, $ave, $status);

        // Execute the prepared statement
        if (mysqli_stmt_execute($insertStmt)) {
            // Redirect back to the same page to show the updated values
            header("Location: progress.php?lastname=" . urlencode($lastName) . "&subject=" . urlencode($subject));
            exit();
        } else {
            // Handle the case when the query fails
            echo "Error inserting record: " . mysqli_stmt_error($insertStmt);
        }

        // Close the prepared statement
        mysqli_stmt_close($insertStmt);
    } else {
        // Handle the case when the prepared statement fails
        echo "Error preparing insert statement: " . mysqli_error($con);
    }}}

    // Close the database connection
    mysqli_close($con);
}
?>
