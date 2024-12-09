<?php
require_once '../connection.php';
session_start();
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

<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- bootstrap and css -->
  <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/announce.css">
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

  <title>Teacher | Remarks List</title>
</head>

<body>
  <nav class="navbar navbar-light" style="background-color: #98c1d9;">
    <div class="container-fluid">
      <a class="navbar-brand" aria-disabled="true">
        <img src="../photos/logocolor.png" class="me-2" height="50" alt="Logo" />
        <small>Tutor House | LMS</small>
      </a>
      <a href="../logout.php" class="btn btn-primary my-2 my-sm-0"><span class="glyphicon glyphicon-log-out"></span>Logout</a>
    </div>
  </nav>

  <div class="container-wrapper">
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
    <div class="content">
      <div class="main-content">
        <div class="activity-upload-btn">
        <a href="../dashboards/admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        <br>
        <table class="table" style="border:5px solid black">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Email</th>
            <th scope="col">Full Name</th>
            <th scope="col">Remarks</th>
            <th scope="col">Operation</th>
          </tr>
        </thead>
        <tbody>

          <?php
          require '../connection.php';
              $sql = "SELECT * FROM `ticket`";
              $result = mysqli_query($con, $sql);
              if ($result) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      $id = $row['id'];
                      $email = $row['email'];
                      $name = $row['name'];
                      $remarks = $row['remarks'];

                      // Add a form to handle the submission of the radio button value
                      echo '<tr>
                                <td>' . $id . '</td>
                                <td>' . $email . '</td>
                                <td>' . $name . '</td>
                                <td>
                                    <form action="../crud/ud_remarks.php" method="post">
                                        <input type="hidden" name="id" value="' . $id . '">
                                        <label>
                                            <input type="radio" name="remarks" value="Unresolved" ' . ($remarks === 'Unresolved' ? 'checked' : '') . '> Unresolved
                                        </label>
                                        <label>
                                            <input type="radio" name="remarks" value="Resolved" ' . ($remarks === 'Resolved' ? 'checked' : '') . '> Resolved
                                        </label>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </td>
                                <td>
                                    <!-- Modify the button link to include lastname as a parameter -->
                                    <a href="../studentinfo/studentlist.php?lastname=' . urlencode($name) . ' class="btn btn-primary">Resolve</a>
                                </td>
                            </tr>';
                  }
              }

          ?>
        </tbody>
      </table>
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


<div id="announcementModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="modal-title">Announcement Title</div>
    <div class="content">Announcement Content</div>
  </div>
</div>
</body>
</html>