<?php
require_once '../../../connection.php';

// Get the email of the logged-in student from the session
session_start();
if (!isset($_SESSION['email']) || ($_SESSION['type'] !== 'student' && $_SESSION['type'] !== 'admin')) {
    header("Location: ../login.php");
    exit();
}
$email = $_SESSION['email'];

// Fetch the last name based on the student's email
$lastNameQuery = "SELECT lastname FROM tblstudentinfo WHERE email = '$email'";
$lastNameResult = mysqli_query($con, $lastNameQuery);
$lastNameRow = mysqli_fetch_assoc($lastNameResult);
$lastName = $lastNameRow['lastname'];

// Define an array of subjects for the buttons
$subjects = ['Mathematics', 'Science', 'English', 'Filipino', 'Reading'];

// Get the subject from the query parameter, if provided
if (isset($_GET['subject']) && in_array($_GET['subject'], $subjects)) {
    $subject = $_GET['subject'];
} else {
    // Set a default subject (e.g., Mathematics) if no subject is provided or if it's invalid
    $subject = 'Mathematics';
}

// Fetch activities data along with the title based on the student's last name and subject
$activitiesQuery = "SELECT a.activityid, a.remarks AS score, a.name AS title
                    FROM actsubmit AS a
                    WHERE a.studname = '$lastName' AND EXISTS (
                        SELECT 1 FROM activities AS act
                        WHERE a.activityid = act.id AND act.subject = '$subject'
                    )";
$activitiesResult = mysqli_query($con, $activitiesQuery);
$activitiesData = mysqli_fetch_all($activitiesResult, MYSQLI_ASSOC);

// Fetch assessments data along with the title based on the student's last name and subject
$assessmentsQuery = "SELECT a.assessid, a.remarks AS score, a.name AS title
                     FROM assesssubmit AS a
                     WHERE a.studname = '$lastName' AND EXISTS (
                        SELECT 1 FROM assessments AS assess
                        WHERE a.assessid = assess.id AND assess.subject = '$subject'
                    )";
$assessmentsResult = mysqli_query($con, $assessmentsQuery);
$assessmentsData = mysqli_fetch_all($assessmentsResult, MYSQLI_ASSOC);

// Fetch data from the "assess" table for the specific subject and lastname
$progressSummaryQuery = "SELECT initial, act, ave, ass, final, status FROM assess 
                         WHERE lastname = '$lastName' AND subject = '$subject'";

$progressSummaryResult = mysqli_query($con, $progressSummaryQuery);
$progressSummaryData = mysqli_fetch_assoc($progressSummaryResult);

// Fetch data from the "assess" table for the specific subject and lastname
$progressSummaryQuery = "SELECT initial, act, ave, ass, final, status FROM assess 
                         WHERE lastname = '$lastName' AND subject = '$subject'";

$progressSummaryResult = mysqli_query($con, $progressSummaryQuery);
$progressSummaryData = mysqli_fetch_assoc($progressSummaryResult);

// Extract the values from the fetched data with default values
$initial = $progressSummaryData['initial'] ?? 'Ungraded';
$act = $progressSummaryData['act'] ?? null;
$ave = $progressSummaryData['ave'] ?? null;
$ass = $progressSummaryData['ass'] ?? null;
$final = $progressSummaryData['final'] ?? 'Ungraded';
$status = $progressSummaryData['status'] ?? 'Pass';

function convertToLetterGrade($average) {
    if ($average >= 5.0) {
        return 'A';
    } elseif ($average >= 4.0) {
        return 'B';
    } elseif ($average >= 3.0) {
        return 'C';
    } elseif ($average >=2.0) {
        return 'D';
    } elseif ($average >=1.0) {
        return 'E';
    }
    else {
      return 'F';
    }
}

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
  <link rel="stylesheet" href="../../../bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../../css/style.css">
  <link rel="stylesheet" href="../../../css/announce.css">
  <link rel="icon" type="image/x-icon" href="../../../photos/logocolor.png">
      <script>
      // Disable back button
      window.onload = function() {
        history.pushState({}, "", "");
        window.onpopstate = function() {
          history.pushState({}, "", "");
        };
      };
    </script>

  <title>Student | Progress</title>
</head>

<body>
  <nav class="navbar navbar-light" style="background-color: #98c1d9;">
    <div class="container-fluid">
      <a class="navbar-brand" aria-disabled="true">
        <img src="../../../photos/logocolor.png" class="me-2" height="50" alt="Logo" />
        <small>Tutor House | LMS</small>
      </a>
      <a href="../../../logout.php" class="btn btn-primary my-2 my-sm-0"><span class="glyphicon glyphicon-log-out"></span>Logout</a>
    </div>
  </nav>

  <div class="container-wrapper">
    <div class="sidebar">
        <ul>
        <li><a href="../../../dashboards/dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
        </ul>
        <small class="text-muted pl-3">Learning Materials</small>
        <ul>
          <li><a href="../studlessons.php"><i class="fas fa-file-invoice"></i>Lessons</a></li>
        </ul>
        <small class="text-muted px-3">Activities</small>
        <ul>
          <li><a href="../studactivities.php"><i class="fas fa-video"></i>Activities</a></li>
          <li><a href="../studassessments.php"><i class="fas fa-id-badge"></i>Assessments</a></li>
        </ul>
        <small class="text-muted px-3">Progress</small>
        <ul>
        <li><a href="../remarks/progress.php"><i class="fas fa-id-badge"></i>View Remarks</a></li>
        <li><a href="../comments.php"><i class="fas fa-id-badge"></i>Comments</a></li>
      </ul>
        <small class="text-muted px-3">Personal Information</small>
        <ul>
          <li><a href="../../../studentinfo/personalinfo.php"><i class="fas fa-external-link-alt"></i>View Personal Info</a></li>
        </ul>
      </div>
    <div class="content">
      <div class="main-content">
          <h2><?php echo $subject; ?> Progress for <?php echo $lastName; ?></h2><br>
          <h3>Activities</h3>
          <div>
              <!-- Links to the same page with different subject as a query parameter -->
              <?php foreach ($subjects as $subj) : ?>
                  <a class="btn btn-primary <?php echo $subject === $subj ? 'active' : ''; ?>" href="./progress.php?subject=<?php echo urlencode($subj); ?>"><?php echo $subj; ?></a>
              <?php endforeach; ?>
          </div>
          <table class="table table-bordered">
              <thead>
                  <tr>
                      <th>Activity ID</th>
                      <th>Title</th>
                      <th>Score</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($activitiesData as $activity) : ?>
                      <tr>
                          <td><?php echo htmlspecialchars($activity['activityid']); ?></td>
                          <td><?php echo htmlspecialchars($activity['title']); ?></td>
                          <td><?php echo htmlspecialchars($activity['score']); ?></td>
                      </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>

          <h3>Assessments</h3>
          <table class="table table-bordered">
              <thead>
                  <tr>
                      <th>Assessment ID</th>
                      <th>Title</th>
                      <th>Score</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($assessmentsData as $assessment) : ?>
                      <tr>
                          <td><?php echo htmlspecialchars($assessment['assessid']); ?></td>
                          <td><?php echo htmlspecialchars($assessment['title']); ?></td>
                          <td><?php echo htmlspecialchars($assessment['score']); ?></td>
                      </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
          <h3>Progress Summary</h3>
          <input type="hidden" name="lastname" value="<?php echo urlencode($lastName); ?>">
          <input type="hidden" name="subject" value="<?php echo urlencode($subject); ?>">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Initial Assessment</th>
              <th>Activities Average</th>
              <th>Assessment Average</th>
              <th>Final Average</th>
              <th>Final Assessment</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            <td><?php echo $initial === null ? 'Ungraded' : htmlspecialchars($initial); ?></td>
            <td><?php echo $act === null ? 'Ungraded' : convertToLetterGrade($act); ?></td>
            <td><?php echo $ave === null ? 'Ungraded' : convertToLetterGrade($ave); ?></td>
            <td><?php echo $ass === null ? 'Ungraded' : convertToLetterGrade($ass); ?></td>
            <td><?php echo $final === null ? 'Ungraded' : htmlspecialchars($final); ?></td>
            <td><?php echo $status === null ? 'Pass' : htmlspecialchars($status); ?></td>
            </tr>
          </tbody>
        </table>
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