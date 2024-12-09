<?php
// teacher_uploaded_lessons.php

// ... Perform database connection ...

// Example using MySQLi (replace with your actual database connection code)
$con = new mysqli('localhost', 'root', '', 'tutordb');
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Retrieve the uploaded lessons from the database
$sql = "SELECT id, title, description, subject, level, file_path FROM lessons";
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
  <link rel="stylesheet" href="../../css/tutlessons.css">
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
    

  <title> Admin | Review Lessons</title>
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
        <small class="text-muted pl-3">Manage Students</small>
        <ul>
          <li><a href="../../dashboards/teacher_dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
          <li><a href="./admlesson.php"><i class="far fa-credit-card"></i>Lessons </a></li>
        </ul>
        <small class="text-muted px-3">Assessments</small>
        <ul>
          <li><a href="./admacts.php"><i class="far fa-file-invoice"></i>Activities</a></li>
          <li><a href="./admassess.php"><i class="fas fa-id-badge"></i>Assessments</a></li>
        </ul>
        <small class="text-muted px-3">Progress</small>
        <ul>
          <li><a href="./admremarks.php"><i class="fas fa-external-link-alt"></i>Remarks</a></li>
          <li><a href="./admcomments.php"><i class="fas fa-code"></i>Add Comments</a></li>
        </ul>
      </div>
    <div class="content">
      <div class="main-content">
        <div class="lesson-list">
          <h1> Lessons </h1>
        <?php
        if ($result->num_rows > 0) {
            // Display the list of uploaded lessons
            while ($row = $result->fetch_assoc()) {
                $lessonId = $row['id'];
                $lessonTitle = $row['title'];
                $lessonDescription = $row['description'];
                $lessonSubject = $row['subject'];
                $lessonLevel = $row['level'];
                $lessonFilePath = $row['file_path'];
                ?>

                <div class="lesson-card">
                    <div class="lesson-title"><?php echo $lessonTitle; ?></div>
                    <div class="lesson-description"><?php echo $lessonDescription; ?></div>
                    <div class="lesson-subject"><?php echo $lessonSubject; ?></div>
                    <div class="lesson-level"><?php echo $lessonLevel; ?></div>
                    <a href="<?php echo $lessonFilePath; ?>" download class="btn btn-primary">Download</a>
                    <a href="../../crud/editlesson.php? id=<?php echo $lessonId; ?>" class="btn btn-primary">Edit</a>
                    <form method="post" action="../../crud/deletelesson.php" onsubmit="return confirm('Are you sure you want to delete this record?')">
                        <input type="hidden" name="lessons" value="lessons"> <!-- Use the correct table name here -->
                        <input type="hidden" name="record_id" value="<?php echo $lessonId; ?>">
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                      </form>
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
    <div class="lesson-upload-btn">
        <a href="uploadlesson.php" class="btn btn-primary">Upload Lesson</a>
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