<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "tutordb";

$con = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $content = $_POST["content"];
  $name = $_POST["name"];
  $subject = $_POST["subject"];

  // Insert the announcement into the database
  $sql = "INSERT INTO comments (description, name, subject, content) VALUES ('description', '$name', '$subject', '$content')";
  
  // Execute the query using your database connection
  $result = $con->query($sql);

  // Check if the query was successful
  if ($result) {
    // Redirect back to the dashboard after successful insertion
    header("Location: ../lms/admin/comments.php");
    exit;
  } else {
    // Handle the case when the query fails
    echo "Error: " . mysqli_error($con);
  }
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

    <title> Admin | Add Comment </title>


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
        <small class="text-muted pl-3">Manage Students</small>
        <ul>
          <li><a href="./teacher_dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
          <li><a href="../lms/teacher/tutlessons.php"><i class="far fa-credit-card"></i>Lessons </a></li>
        </ul>
        <small class="text-muted px-3">Assessments</small>
        <ul>
          <li><a href="../lms/teacher/tutactivities.php"><i class="far fa-file-invoice"></i>Activities</a></li>
          <li><a href="../lms/teacher/tutassessments.php"><i class="fas fa-id-badge"></i>Assessments</a></li>
        </ul>
        <small class="text-muted px-3">Progress</small>
        <ul>
          <li><a href="../lms/teacher/remarks.php"><i class="fas fa-external-link-alt"></i>Remarks</a></li>
          <li><a href="../crud/addcomment.php"><i class="fas fa-code"></i>Comments</a></li>
        </ul>
      </div>

      <div class="main-content">
        <h2><center>Add Comment</center></h2>
          <form action="./addcomment.php" method="POST">
          <label for="description">Description</label>
          <input type="text" id="description" name="description" placeholder="Comment context" required><br>
          <label for="lastname">Name</label>
          <input type="text" id="lastname" name="name" required><br>
          <label for="Subject">Subject</label>
          <select class="form-control" id="subject" name="subject" required><br>
            <option selected>Mathematics</option>
            <option>Science</option>
            <option>English</option>
            <option>Filipino</option>
            <option>Reading</option>
          </select><br>
          <label for="content">Comment</label><br>
          <textarea id="content" name="content" required></textarea><br>

          <input type="submit" value="Add Comment">
        </form>
      </div>
    </div>
    <?php require '../views/partials/footer.php' ?>
  </body>

  </html>