<?php
session_start();
if (!isset($_SESSION['email']) || ( $_SESSION['type'] !== 'admin')) {
    header("Location: ../login.php");
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$database = "tutordb";

$con = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = $_POST["title"];
  $content = $_POST["content"];

  // Prepare the SQL statement using a parameterized query
  $sql = "INSERT INTO announcements (title, content) VALUES (?, ?)";
  $stmt = $con->prepare($sql);

  // Bind the parameters to the statement
  $stmt->bind_param("ss", $title, $content);

  // Execute the query
  if ($stmt->execute()) {
    // Redirect back to the dashboard after successful insertion
    header("Location: ./announcementlist.php");
    exit;
  } else {
    // Handle the case when the query fails
    echo "Error: " . $stmt->error;
  }

  // Close the prepared statement
  $stmt->close();
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
          <li><a href="../dashboards/admin_dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
        </ul>
        <small class="text-muted pl-3">PERSONNEL MANAGER</small>
        <ul>
          <li><a href="../crud/enroll.php"><i class="fas fa-enrol"></i>Enroll Student</a></li>
          <li><a href="../studentinfo/studentlist.php"><i class="far fa-studlist"></i>Student List </a></li>
          <li><a href="../studentinfo/teacherlist.php"><i class="fas fa-tchrlist"></i>Tutor List</a></li>
          <li><a href="./ticket.php"><i class="fas fa-tchrlist"></i>Ticket List</a></li>
        </ul>
        <small class="text-muted px-3">ACADEMIC MANAGER</small>
        <ul>
          <li><a href="../lms/teacher/tutlessons.php"><i class="far fa-calendar-alt"></i>Review Lessons</a></li>
          <li><a href="../lms/teacher/tutassessments.php"><i class="fas fa-video"></i>Review Assessments</a></li>
          <li><a href="../lms/teacher/tutactivities.php"><i class="fas fa-id-badge"></i>Review Activities</a></li>
          <li><a href="../lms/teacher/remarks.php"><i class="fas fa-id-badge"></i>Review Remarks</a></li>
          <li><a href="../lms/teacher/tutcomments.php"><i class="fas fa-id-badge"></i>Review Comments</a></li>
        </ul>
        <small class="text-muted px-3">ANNOUNCEMENTS</small>
        <ul>
          <li><a href="./announcementlist.php"><i class="fas fa-external-link-alt"></i>View Announcements</a></li>
          <li><a href="./addannounce.php"><i class="fas fa-code"></i>Add Announcements</a></li>
        </ul>
      </div>

      <div class="main-content">
        <h2><center>New Announcement</center></h2>
          <form action="./addannounce.php" method="POST">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" required><br>

          <label for="content">Content</label><br>
          <textarea id="content" name="content" required></textarea><br>

          <input type="submit" value="Add Announcement">
        </form>
      </div>
    </div>
    <?php require '../views/partials/footer.php' ?>
  </body>

  </html>