<?php
require_once '../connection.php';

// Fetch past announcements from the database
$query = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = mysqli_query($con, $query);

// Check if the query was executed successfully
if ($result) {
    // Fetch the results as an array
    $announcements = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/announce.css">
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

    <title> LMS | Student Dashboard </title>

    <nav class="navbar navbar-light" style="background-color: #98c1d9;">
      <div class="container-fluid">
        <a class="navbar-brand" aria-disabled="true">
          <img src="../photos/logocolor.png" class="me-2" height="50" alt="Logo" />
          <small>Tutor House | LMS</small> </a>
        <a href="../logout.php" class="btn btn-primary my-2 my-sm-0"><span class="glyphicon glyphicon-log-out"></span>Logout</a>
      </div>
    </nav>
  </head>

  <body>
    <div class="wrapper d-flex">
    <div class="sidebar">
        <ul>
        <li><a href="./dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
        </ul>
        <small class="text-muted pl-3">Learning Materials</small>
        <ul>
          <li><a href="../lms/student/studlessons.php"><i class="fas fa-file-invoice"></i>Lessons</a></li>
        </ul>
        <small class="text-muted px-3">Activities</small>
        <ul>
          <li><a href="../lms/student/studactivities.php"><i class="fas fa-video"></i>Activities</a></li>
          <li><a href="../lms/student/studassessments.php"><i class="fas fa-id-badge"></i>Assessments</a></li>
        </ul>
        <small class="text-muted px-3">Progress</small>
        <ul>
        <li><a href="../lms/student/remarks/progress.php"><i class="fas fa-id-badge"></i>View Remarks</a></li>
        <li><a href="../lms/student/comments.php"><i class="fas fa-id-badge"></i>Comments</a></li>
      </ul>
        <small class="text-muted px-3">Personal Information</small>
        <ul>
          <li><a href="../studentinfo/personalinfo.php"><i class="fas fa-external-link-alt"></i>View Personal Info</a></li>
        </ul>
      </div>


      <div class="main-content">
        <div class="card-container">
          <div class="card">
            <img class="card-img-top" src="../photos/student.png" alt="Card image cap" style="height:200px; width:100%;">
            <div class="card-body">
              <h5 class="card-title">Profile</h5>
              <p class="card-text">View your own Profile.</p>
              <a href="../studentinfo/personalinfo.php" class="btn btn-primary">View Profile</a>
            </div>
          </div>
          <div class="card">
            <img class="card-img-top" src="../photos/lesson.png" alt="Card image cap" style="height:200px; width:100%;">
            <div class="card-body">
              <h5 class="card-title">Lessons</h5>
              <p class="card-text">Check all lessons uploaded by the tutors.</p>
              <a href="../lms/student/studlessons.php" class="btn btn-primary">View Lessons</a>
            </div>
          </div>
          <div class="card">
            <img class="card-img-top" src="../photos/activities.png" alt="Card image cap" style="height:200px; width:100%;">
            <div class="card-body">
              <h5 class="card-title">Activities</h5>
              <p class="card-text">View all activities uploaded by the tutors.</p>
              <a href="../lms/student/studactivities.php" class="btn btn-primary">View Activities</a>
            </div>
          </div>
          <div class="card">
            <img class="card-img-top" src="../photos/activities.png" alt="Card image cap" style="height:200px; width:100%;">
            <div class="card-body">
              <h5 class="card-title">Assessments</h5>
              <p class="card-text">View assessments uploaded by the tutors.</p>
              <a href="../lms/student/studassessments.php" class="btn btn-primary">View Assessments</a>
            </div>
          </div>
          <div class="card">
            <img class="card-img-top" src="../photos/grades.png" alt="Card image cap" style="height:200px; width:100%;">
            <div class="card-body">
              <h5 class="card-title">Progress</h5>
              <p class="card-text">View your own learner's progress report.</p>
              <a href="../lms/student/remarks/progress.php" class="btn btn-primary">View Grades</a>
            </div>
          </div>
          <div class="card">
            <img class="card-img-top" src="../photos/notes.png" alt="Card image cap" style="height:200px; width:100%;">
            <div class="card-body">
              <h5 class="card-title">Tutor's Notes</h5>
              <p class="card-text">View left notes/comments by the tutors.</p>
              <a href="../lms/student/comments.php" class="btn btn-primary">View Notes</a>
            </div>
          </div>
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
    <div id="footer" class="footer">
      <p>
        <center>© 2023 Tutor House Inc.</center>
      </p>
    </div>
    <script src="../bootstrap/js/dist/bootstrap.min.js"></script>
    <script src="../bootstrap/assets/js/vendor/jquery-slim.min.js"></script>
    <script src="../bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="../bootstrap/js/dist/util.js"></script>
    <script src="../bootstrap/js/dist/dropdown.js"></script>
  </body>

  </html>