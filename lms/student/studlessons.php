<?php
// Include the database connection file
require_once '../../connection.php';
session_start();
if (!isset($_SESSION['email']) || ($_SESSION['type'] !== 'student')) {
    header("Location: ../login.php");
    exit();
}

// Prevent caching of the page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Check if the user is logged in
if (!isset($_SESSION['email']) || $_SESSION['type'] !== 'student') {
  header("Location: ../login.php"); // Redirect to login page if user is not logged in or doesn't have the student role
  exit();
}

$studentLevel = $_SESSION['level'];
$sql = "SELECT id, title, description, level, file_path FROM lessons WHERE level = '$studentLevel'";
$result = $con->query($sql);

// Fetch past announcements from the database
$query = "SELECT * FROM announcements ORDER BY created_at DESC";
$annresult = mysqli_query($con, $query);

// Check if the query was executed successfully
if ($annresult) {
    // Fetch the results as an array
    $announcements = mysqli_fetch_all($annresult, MYSQLI_ASSOC);
} else {
    // Handle the case when the query fails
    $announcements = [];
}

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
  <link rel="stylesheet" href="../../css/tutassessments.css">
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

  <title>Student | Lessons</title>
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
    <div class="content">
      <div class="main-content">
       <h1><center> Lesson List </center></h1><br><br>
        <div class="assess-list">
        <?php
        if ($result->num_rows > 0) {
            // Display the lessons as rectangles
            while ($row = $result->fetch_assoc()) {
                $lessonId = $row['id'];
                $lessonTitle = $row['title'];
                $lessonDescription = $row['description'];
                $lessonFilePath = $row['file_path'];
                $lessonLevel = $row['level'];
                ?>

                <div class="assess-card">
                    <div class="assess-title"><?php echo $lessonTitle; ?></div>
                    <div class="assess-description"><?php echo $lessonDescription; ?></div>
                    <div class="assess-level"><?php echo $lessonLevel; ?></div>
                    <a href="<?php echo $lessonFilePath; ?>" download class="assess-download-btn">Download</a>
                </div>

                <?php
            }
        } else {
            // No lessons found
            echo "No file found.";
        }

        $con->close();
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