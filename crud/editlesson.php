<?php
// Include the database connection file
require_once '../connection.php';

// Check if the form is submitted for updating the lesson
if (isset($_POST['update'])) {
    $id = $_POST['lesson_id'];
    $newTitle = $_POST['lesson_title'];
    $newDescription = $_POST['lesson_description'];
    $newSubject = $_POST['lesson_subject'];
    $newLevel = $_POST['lesson_level'];
    
    // Check if a new file is uploaded
    if ($_FILES['lesson_attachment']['name']) {
    $newFilePath = "../files/" . $_FILES['lesson_attachment']['name'];

      // Upload the new file to the server
          if (move_uploaded_file($_FILES['lesson_attachment']['tmp_name'], $newFilePath)) {
        // File upload successful, update the file_path in the database
        $sql = "UPDATE lessons SET title = ?, description = ?, subject = ?, level = ?, file_path = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssi", $newTitle, $newDescription, $newSubject, $newLevel, $newFilePath, $id);
    }     else {
        // File upload failed, display an error message or handle it accordingly
        echo "Error uploading file.";
        exit();
    }
    }     else {
    // No new file uploaded, update the other fields in the database
    $sql = "UPDATE lessons SET title = ?, description = ?, subject = ?, level = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssi", $newTitle, $newDescription, $newSubject, $newLevel, $id);
    }
    // Perform the update query
    if ($stmt->execute()) {
        // Update successful, redirect back to the page
        header('Location: ../lms/teacher/tutlessons.php');
        exit();
    } else {
        // Update failed, display an error message or handle it accordingly
        echo "Error updating lesson.";
    }
}
// Check if the lesson ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the lesson details from the database based on the ID
    $sql = "SELECT id, title, description, subject, level, file_path FROM lessons WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Fetch the lesson details
        $row = $result->fetch_assoc();
        $lessonId = $row['id'];
        $lessonTitle = $row['title'];
        $lessonDescription = $row['description'];
        $lessonSubject = $row['subject'];
        $lessonLevel = $row['level'];
        $lessonattachment = $row['file_path'];
        // Add other fields as needed

    } else {
        // lesson not found with the provided ID, display an error message or handle it accordingly
        echo "Lesson not found.";
    }
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
  <link rel="stylesheet" href="../css/tutlessons.css">
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
    

  <title> Teacher | Edit</title>
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
          <li><a href="../lms/teacher/remarklist.php"><i class="fas fa-external-link-alt"></i>Remarks</a></li>
          <li><a href="../lms/teacher/remarks.php"><i class="fas fa-code"></i>Edit and Submit Remarks</a></li>
        </ul>
      </div>
    <div class="content">
      <div class="main-content">
        <div class="lesson-upload-form">
        <h2>Edit lesson</h2>
        <form action="editlesson.php" method="POST" enctype="multipart/form-data">
          <!-- Your lesson edit form fields here (title, description, subject, attachment) -->
          <!-- Example: -->
          <input type="hidden" name="lesson_id" value="<?php echo $lessonId; ?>">
          <input type="text" name="lesson_title" placeholder="lesson Title" value="<?php echo $lessonTitle; ?>"
            required>
          <textarea name="lesson_description" placeholder="lesson Description" required><?php echo $lessonDescription; ?></textarea>
          <select type="form-select" name="lesson_subject" aria-label="Default select example" value="<?php echo $lessonSubject; ?>" required>
                <option>Mathematics</option>
                <option>English</option>
                <option>Science</option>
                <option>Filipino</option>
                <option>Reading</option>
              </select>
            <select type="form-select" name="lesson_level" aria-label="Default select example" value="<?php echo $lessonLevel; ?>" required>
                <option>Kinder</option>
                <option>Grade 1</option>
                <option>Grade 2</option>
                <option>Grade 3</option>
                <option>Grade 4</option>
                <option>Grade 5</option>
                <option>Grade 6</option>
              </select>
          <!-- Add the file attachment field -->
          <input type="file" name="lesson_attachment"  value="<?php echo $lessonattachment; ?>" required>
          <button type="submit" name="update">Update lesson</button>
        </form>
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