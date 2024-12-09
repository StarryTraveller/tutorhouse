<?php
require_once '../../connection.php';

session_start(); // Start session

// Prevent caching of the page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Assuming the student's email is stored in the session variable 'email'
$studentEmail = $_SESSION['email'];

$query = "SELECT lastname FROM tblstudentinfo WHERE email = '$studentEmail'";
$result = mysqli_query($con, $query);

// Check if the query was executed successfully
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $studentLastName = $row['lastname'];
} else {
    // Handle the case when the query fails or the email is not found
    die("Error: Unable to fetch student's last name");
}

// Fetch comments made by the tutor for the student
$query = "SELECT * FROM comments WHERE name = '$studentLastName' ORDER BY created_at DESC";
$result = mysqli_query($con, $query);

// Check if the query was executed successfully
if ($result) {
    // Fetch the results as an array
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    // Handle the case when the query fails
    $comments = [];
}
// Fetch past announcements from the database
$annquery = "SELECT * FROM announcements ORDER BY created_at DESC";
$annresult = mysqli_query($con, $annquery);

// Check if the query was executed successfully
if ($annresult) {
    // Fetch the results as an array
    $announcements = mysqli_fetch_all($annresult, MYSQLI_ASSOC);
} else {
    // Handle the case when the query fails
    $announcements = [];
}
// Close the database connection
mysqli_close($con);
?>
<DOCTYPE !html>
  <html>

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- bootstrap and css -->
    <link rel="stylesheet" href="../../bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/announce.css">
    <link rel="stylesheet" href="../../css/comments.css">
    <link rel="icon" type="image/x-icon" href="../../photos/logocolor.png">
        <script>
      // Disable back button
      window.onload = function() {
        history.pushState({}, "", "");
        window.onpopstate = function() {
          history.pushState({}, "", "");
        };
      };
    </script>

    <title> Student | Comment/Observation </title>


  </head>

  <body>
    <nav class="navbar navbar-light" style="background-color: #98c1d9;">
      <div class="container-fluid">
        <a class="navbar-brand" aria-disabled="true">
          <img src="../../photos/logocolor.png" class="me-2" height="50" alt="Logo" />
          <small>Tutor House | LMS</small> </a>
        <a href="../logout.php" class="btn btn-primary my-2 my-sm-0"><span class="glyphicon glyphicon-log-out"></span>Logout</a>
      </div>
    </nav>
    <div class="wrapper d-flex">
    <div class="sidebar">
        <ul>
        <li><a href="../../dashboards/dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
        </ul>
        <small class="text-muted pl-3">Learning Materials</small>
        <ul>
          <li><a href="./studlessons.php"><i class="fas fa-file-invoice"></i>Lessons</a></li>
        </ul>
        <small class="text-muted px-3">Activities</small>
        <ul>
          <li><a href="./studactivities.php"><i class="fas fa-video"></i>Activities</a></li>
          <li><a href="./studassessments.php"><i class="fas fa-id-badge"></i>Assessments</a></li>
        </ul>
        <small class="text-muted px-3">Progress</small>
        <ul>
        <li><a href="./remarks/progress.php"><i class="fas fa-id-badge"></i>View Remarks</a></li>
        <li><a href="./comments.php"><i class="fas fa-id-badge"></i>Comments</a></li>
      </ul>
        <small class="text-muted px-3">Personal Information</small>
        <ul>
          <li><a href="../../studentinfo/personalinfo.php"><i class="fas fa-external-link-alt"></i>View Personal Info</a></li>
        </ul>
      </div>

      <div class="main-content">
          <br>
          <h2><center>Comments from Tutor</center></h2>
          <div class="comment-wrapper">
              <?php
              // Check if there are any comments
              if (count($comments) > 0) {
                  foreach ($comments as $comment) {
                      echo '<div class="card">';
                      echo '<div class="card-body">';
                      echo '<h5 class="card-title">' . htmlspecialchars($comment["subject"]) . '</h5>';
                      echo '<h6 class="card-subtitle mb-2 text-muted">Posted on ' . htmlspecialchars($comment["created_at"]) . '</h6>';

                      // Truncate the content to 25 characters
                      $truncatedContent = substr(htmlspecialchars($comment["content"]), 0, 25);
                      echo '<p class="card-text">' . htmlspecialchars($truncatedContent) . '</p>';

                      echo '<a href="#" class="card-link read-more-link" data-content="' . htmlspecialchars($comment["content"]) . '">Read more..</a>';
                      echo '</div>';
                      echo '</div>';
                  }
              } else {
                  echo '<p>No comments found.</p>';
              }
              ?>
          </div>
      </div>
      <div class="announcement-section">
        <br>
        <h2>Announcements</h2><br>
        <div class="announcement-wrapper">
            <?php
            // Check if there are any past announcements
              if (count($announcements) > 0) {
                foreach ($announcements as $announcement) {
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($announcement["title"]) . '</h5>';
                    echo '<h6 class="card-subtitle mb-2 text-muted">Posted on ' . htmlspecialchars($announcement["created_at"]) . '</h6>';

                    // Truncate the content to 25 characters
                    $truncatedContent = substr(htmlspecialchars($announcement["content"]), 0, 25);
                    echo '<p class="card-text">' . $truncatedContent . '...</p>';

                    echo '<a href="#" class="card-link read-more-link" data-content="' . htmlspecialchars($announcement["content"]) . '">Read more..</a>';
                    echo '</div>';
                    echo '</div>';

         }  } else {
                echo '<p>No past announcements found.</p>';
            }
          ?>
          </div>
      </div>
    </div>
    <?php require '../../views/partials/footer.php' ?>


  <script>
    // Disable back button
    window.onload = function() {
      history.pushState({}, "", "");
      window.onpopstate = function() {
        history.pushState({}, "", "");
      };
    };
  </script>
   <script>
 document.addEventListener('DOMContentLoaded', function () {
  const readMoreLinks = document.querySelectorAll('.read-more-link');
  const modal = document.getElementById('announcementModal');
  const modalTitle = modal.querySelector('.modal-title');
  const modalContent = modal.querySelector('.content');

  readMoreLinks.forEach((link) => {
    link.addEventListener('click', function (event) {
      event.preventDefault();
      const title = this.previousElementSibling.previousElementSibling.previousElementSibling.textContent;
      const content = this.dataset.content;
      modalTitle.textContent = title;
      modalContent.textContent = content;
      modal.style.display = 'block';
    });
  });

  const closeButton = modal.querySelector('.close');
  closeButton.addEventListener('click', function () {
    modal.style.display = 'none';
  });

  window.addEventListener('click', function (event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });
});


</script>


<div id="announcementModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="modal-title">Announcement Title</div>
    <div class="content">Announcement Content</div>
  </div>
</div>
</body>

</html>