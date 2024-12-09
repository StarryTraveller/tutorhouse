<?php
session_start();
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form was submitted

    // Validate and sanitize the form inputs
    $announcement_id = $_POST['announcement_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // You can add additional validation if needed

    // Update the announcement in the database
    $query = "UPDATE announcements SET title = ?, content = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $announcement_id);

    if (mysqli_stmt_execute($stmt)) {
        // The announcement was updated successfully
        // Redirect to the announcement list or display a success message
        header("Location: ../views/announcementlist.php");
        exit();
    } else {
        // Handle the case when the update fails
        echo 'Failed to update announcement.';
        exit();
    }

    mysqli_stmt_close($stmt);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['announcement_id'])) {
    // If the form was not submitted via POST, check if the announcement ID is provided as a parameter

    // Retrieve the announcement ID from the URL parameter
    $announcement_id = $_GET['announcement_id'];

    // Fetch the announcement details from the database using the ID
    $query = "SELECT * FROM announcements WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $announcement_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $announcement = mysqli_fetch_assoc($result);

    if (!$announcement) {
        // Handle the case when the announcement is not found
        echo 'Announcement not found.';
        exit();
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // If no announcement ID is provided, handle the error
    echo 'Invalid request method.';
    exit();
}
?>

<DOCTYPE !html>
  <html>

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- bootstrap and css -->
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/addannounce.css">
    <link rel="icon" type="image/x-icon" href="../photos/logocolor.png">
        <script>
      // Disable back button
      window.onload = function() {
        history.pushState({}, "", "");
        window.onpopstate = function() {
          history.pushState({}, "", "");
        };
      };
    </script>

    <title> Admin | Announcement </title>


  </head>

  <body>
    <nav class="navbar navbar-light" style="background-color: #98c1d9;">
      <div class="container-fluid">
        <a class="navbar-brand" aria-disabled="true">
          <img src="../photos/logocolor.png" class="me-2" height="50" alt="Logo" />
          <small>Tutor House | LMS</small> </a>
        <a href="../logout.php" class="btn btn-primary my-2 my-sm-0"><span class="glyphicon glyphicon-log-out"></span>Logout</a>
      </div>
    </nav>
    <div class="wrapper d-flex">
<div class="sidebar">
        <small class="text-muted pl-3">Dashboard</small>
        <ul>
          <li><a href="./admin_dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
        </ul>
        <small class="text-muted pl-3">PERSONNEL MANAGER</small>
        <ul>
          <li><a href="../crud/enroll.php"><i class="fas fa-enrol"></i>Enroll Student</a></li>
          <li><a href="../studentinfo/studentlist.php"><i class="far fa-studlist"></i>Student List </a></li>
          <li><a href="../studentinfo/teacherlist.php"><i class="fas fa-tchrlist"></i>Tutor List</a></li>
        </ul>
        <small class="text-muted px-3">ACADEMIC MANAGER</small>
        <ul>
          <li><a href="../lms/admin/admlesson.php"><i class="far fa-calendar-alt"></i>Review Lessons</a></li>
          <li><a href="../lms/admin/admassess.php"><i class="fas fa-video"></i>Review Assessments</a></li>
          <li><a href="../lms/admin/admacts.php"><i class="fas fa-id-badge"></i>Review Activities</a></li>
        </ul>
        <small class="text-muted px-3">ANNOUNCEMENTS</small>
        <ul>
          <li><a href="../crud/announcementlist.php"><i class="fas fa-external-link-alt"></i>View Announcements</a></li>
          <li><a href="../crud/addannounce.php"><i class="fas fa-code"></i>Add Announcements</a></li>
        </ul>
      </div>

      <div class="main-content">
        <h2><center>New Announcement</center></h2>
          <form action="" method="POST">
          <input type="hidden" name="announcement_id" value="<?php echo htmlspecialchars($announcement["id"]); ?>">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($announcement["title"]); ?>" required><br>

          <label for="content">Content</label><br>
          <textarea id="content" name="content" required><?php echo htmlspecialchars($announcement["content"]); ?></textarea><br>

          <input type="submit" value="Edit Announcement">
        </form>
      </div>
    </div>
    <?php require '../views/partials/footer.php' ?>
  </body>

  </html>