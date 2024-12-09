<?php
require_once '../connection.php';
session_start();
function renderTeacherSidebar()
{
    ?>
    <!-- Teacher sidebar HTML -->
      <div class="sidebar">
        <small class="text-muted pl-3">Manage Students</small>
        <ul>
          <li><a href="../dashboards/teacher_dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
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
          <li><a href="../lms/teacher/tutcomments.php"><i class="fas fa-code"></i>Comments</a></li>
        </ul>
      </div>
    <?php
}

// Function to render admin sidebar
function renderAdminSidebar()
{
    ?>
    <!-- Admin sidebar HTML -->
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
    <?php
}
if (!isset($_SESSION['email']) || ($_SESSION['type'] !== 'teacher' && $_SESSION['type'] !== 'admin')) {
    header("Location: ../login.php");
    exit();
}
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
    <link rel="stylesheet" href="../css/listanunt.css">
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

    <title> Admin | Announcements </title>


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
    <?php
    // Check the user's session type and render the appropriate sidebar
    if ($_SESSION['type'] === 'teacher') {
        renderTeacherSidebar();
    } elseif ($_SESSION['type'] === 'admin') {
        renderAdminSidebar();
    }
    ?>

      <div class="main-content">
        <br><h2><center>Recent Announcements</center></h2>
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

                    // Add the update and delete buttons as form buttons
                    echo '<div class="button-group">';
                    echo '<a href="../crud/updateannounce.php?announcement_id=' . htmlspecialchars($announcement["id"]) . '" class="btn btn-primary mb-2">Update</a>';
                    echo '<form action="../crud/deleteannouncement.php" method="post" onsubmit="return confirm(\'Are you sure you want to delete this announcement?\');">';
                    echo '<input type="hidden" name="announcement_id" value="' . htmlspecialchars($announcement["id"]) . '">';
                    echo '<button type="submit" class="btn btn-danger mb-2">Delete</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

         }  } else {
                echo '<p>No past announcements found.</p>';
            }
          ?>
          </div>
        </div>

    </div>
    <?php require '../views/partials/footer.php' ?>


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