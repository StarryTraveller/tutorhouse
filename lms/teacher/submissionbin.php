<?php
require_once '../../connection.php';
session_start();
function renderTeacherSidebar()
{
    ?>
    <!-- Teacher sidebar HTML -->
      <div class="sidebar">
        <small class="text-muted pl-3">Manage Students</small>
        <ul>
          <li><a href="../../dashboards/teacher_dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
          <li><a href="./tutlessons.php"><i class="far fa-credit-card"></i>Lessons </a></li>
        </ul>
        <small class="text-muted px-3">Assessments</small>
        <ul>
          <li><a href="./tutactivities.php"><i class="far fa-file-invoice"></i>Activities</a></li>
          <li><a href="./tutassessments.php"><i class="fas fa-id-badge"></i>Assessments</a></li>
        </ul>
        <small class="text-muted px-3">Progress</small>
        <ul>
          <li><a href="./remarks.php"><i class="fas fa-external-link-alt"></i>Remarks</a></li>
          <li><a href="./tutcomments.php"><i class="fas fa-code"></i>Comments</a></li>
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
          <li><a href="../../dashboards/admin_dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
        </ul>
        <small class="text-muted pl-3">PERSONNEL MANAGER</small>
        <ul>
          <li><a href="../../crud/enroll.php"><i class="fas fa-enrol"></i>Enroll Student</a></li>
          <li><a href="../../studentinfo/studentlist.php"><i class="far fa-studlist"></i>Student List </a></li>
          <li><a href="../../studentinfo/teacherlist.php"><i class="fas fa-tchrlist"></i>Tutor List</a></li>
          <li><a href="../../views/ticket.php"><i class="fas fa-tchrlist"></i>Ticket List</a></li>
        </ul>
        <small class="text-muted px-3">ACADEMIC MANAGER</small>
        <ul>
          <li><a href="./tutlessons.php"><i class="far fa-calendar-alt"></i>Review Lessons</a></li>
          <li><a href="./tutassessments.php"><i class="fas fa-video"></i>Review Assessments</a></li>
          <li><a href="./tutactivities.php"><i class="fas fa-id-badge"></i>Review Activities</a></li>
          <li><a href="./remarks.php"><i class="fas fa-id-badge"></i>Review Remarks</a></li>
          <li><a href="./tutcomments.php"><i class="fas fa-id-badge"></i>Review Comments</a></li>
        </ul>
        <small class="text-muted px-3">ANNOUNCEMENTS</small>
        <ul>
          <li><a href="../../views/announcementlist.php"><i class="fas fa-external-link-alt"></i>View Announcements</a></li>
          <li><a href="../../views/addannounce.php"><i class="fas fa-code"></i>Add Announcements</a></li>
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

// Check if the user is logged in as a teacher
if (!isset($_SESSION['email']) || $_SESSION['type'] !== 'teacher' && $_SESSION['type'] !== 'admin') {
    header("Location: ../../login.php");
    exit();
}

// Get the activity ID from the URL parameter
if (isset($_GET['activity_id'])) {
    $activityId = $_GET['activity_id'];

    // Fetch the activity details from the 'activities' table based on the activity ID
    $activitySql = "SELECT id, title, subject, level FROM activities WHERE id = '$activityId'";
    $activityResult = $con->query($activitySql);
    $activity = $activityResult->fetch_assoc();

    // Fetch the submissions for the specific activity from the 'actsubmit' table
    $submissionSql = "SELECT * FROM actsubmit WHERE activityid = '$activityId'";
    $submissionResult = $con->query($submissionSql);

    // Check if the query was executed successfully
    if ($submissionResult) {
        // Fetch the submissions as an array
        $submissions = $submissionResult->fetch_all(MYSQLI_ASSOC);
    } else {
        // Handle the case when the query fails
        $submissions = [];
    }
} else {
    // Redirect to the previous page if the activity ID is not provided
    header("Location: ./tutactivities.php");
    exit();
}

// Handle the form submission for updating the remark
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submission_id']) && isset($_POST['remark'])) {
        $submissionId = $_POST['submission_id'];
        $remark = $_POST['remark'];

        // Update the remark for the submission in the database
        $updateSql = "UPDATE actsubmit SET remarks = '$remark' WHERE id = '$submissionId'";
        $updateResult = $con->query($updateSql);

        // Optionally, you can add a check to see if the update was successful or handle errors
    }
}

// Close the database connection
$con->close();
?>


<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- bootstrap and css -->
  <link rel="stylesheet" href="../../bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/announce.css">
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

  <title>Teacher | Activity Bin</title>
</head>

<body>
  <nav class="navbar navbar-light" style="background-color: #98c1d9;">
    <div class="container-fluid">
      <a class="navbar-brand" aria-disabled="true">
        <img src="../../photos/logocolor.png" class="me-2" height="50" alt="Logo" />
        <small>Tutor House | LMS</small>
      </a>
      <a href="../../logout.php" class="btn btn-primary my-2 my-sm-0"><span class="glyphicon glyphicon-log-out"></span>Logout</a>
    </div>
  </nav>

  <div class="container-wrapper">
    <?php
    // Check the user's session type and render the appropriate sidebar
    if ($_SESSION['type'] === 'teacher') {
        renderTeacherSidebar();
    } elseif ($_SESSION['type'] === 'admin') {
        renderAdminSidebar();
    }
    ?>

    <div class="content">
      <div class="main-content">
                <h1><?php echo $activity['title']; ?> Submissions</h1>
                <h5>Subject: <?php echo $activity['subject']; ?></h5>
                <h5>Level: <?php echo $activity['level']; ?></h5>

                <?php if (count($submissions) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Submission ID</th>
                                <th>File Path</th>
                                <th>Date Submitted</th>
                                <th>Student Last Name</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($submissions as $submission): ?>
                    <tr>
                    <td><?php echo $submission['id']; ?></td>
                    <td><a href="<?php echo $submission['file_path']; ?>" download class="btn btn-primary">Download</a></td>
                    <td><?php echo $submission['created_at']; ?></td>
                    <td><?php echo $submission['studname']; ?></td>
                    <td>
                        <form class="remark-form" method="post">
                            <input type="hidden" name="submission_id" value="<?php echo $submission['id']; ?>">
                            <select name="remark" class="remark-dropdown">
                                <option value="ungraded" <?php if ($submission['remarks'] === 'ungraded') echo 'selected'; ?>>Ungraded</option>
                                <option value="A" <?php if ($submission['remarks'] === 'A') echo 'selected'; ?>>A</option>
                                <option value="B" <?php if ($submission['remarks'] === 'B') echo 'selected'; ?>>B</option>
                                <option value="C" <?php if ($submission['remarks'] === 'C') echo 'selected'; ?>>C</option>
                                <option value="D" <?php if ($submission['remarks'] === 'D') echo 'selected'; ?>>D</option>
                                <option value="E" <?php if ($submission['remarks'] === 'E') echo 'selected'; ?>>E</option>
                                <option value="F" <?php if ($submission['remarks'] === 'F') echo 'selected'; ?>>F</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Update Remark</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No submissions found for this activity.</p>
<?php endif; ?>
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
  </div>

  <div id="footer" class="footer">
    <p>
      <center>© 2023 Tutor House Inc.</center>
    </p>
  </div>

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
<script>
    // JavaScript code for updating the remark using AJAX
    document.addEventListener('DOMContentLoaded', function() {
    const remarkForms = document.querySelectorAll('.remark-form');

    remarkForms.forEach((form) => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const submissionId = this.dataset.submissionId;
            const selectedRemark = this.remark.value;

            // Create a new form to send the data to the server
            const formData = new FormData();
            formData.append('submission_id', submissionId);
            formData.append('remark', selectedRemark);

            // Submit the form to the server
            this.submit();
        });
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