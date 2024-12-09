<?php
require_once '../../connection.php';
session_start();
if (!isset($_SESSION['email']) || ($_SESSION['type'] !== 'teacher' && $_SESSION['type'] !== 'admin')) {
    // Check if the user is already on the login page to avoid a redirection loop
    $loginPage = "../../login.php";
    $currentPage = $_SERVER['PHP_SELF'];
    if ($currentPage !== $loginPage) {
        header("Location: $loginPage");
        exit();
    }
}
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
        <small class="text-muted px-3">Personal Info</small>
        <ul>
        <li><a href="../../views/teacherinfo.view.php"><i class="fas fa-external-link-alt"></i>View Personal Info</a></li>
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

// Check if the query parameters 'lastname' and 'subject' are set
if (isset($_GET['lastname']) && isset($_GET['subject'])) {
    // Retrieve the last name and subject from the query parameters
    $lastName = $_GET['lastname'];
    $subject = $_GET['subject'];

    // Fetch activities data along with the title based on the student's last name and subject
    $activitiesQuery = "SELECT a.activityid, a.remarks AS score, a.name AS title
                        FROM actsubmit AS a
                        WHERE a.studname = '$lastName' AND EXISTS (
                            SELECT 1 FROM activities AS act
                            WHERE a.activityid = act.id AND act.subject = '$subject'
                        )";
    $activitiesResult = mysqli_query($con, $activitiesQuery);
    $activitiesData = mysqli_fetch_all($activitiesResult, MYSQLI_ASSOC);
    if ($activitiesResult) {
      // Fetch data from the result set and structure it
      $arr = array();
      foreach($activitiesData as $row) {
          $activity = array(
              "Activity" => (int)$row['title'],
              "Grade" => $row['score'],
          );
          // Add each activity to the activitiesData array
          $arr[] = $activity;
      }
  
      // Create an array to hold the final result
      $result = array(
          "data" => $arr
      );

      $resultJSON = json_encode($result);
  
  } 
    

    // Fetch assessments data along with the title based on the student's last name and subject
    $assessmentsQuery = "SELECT a.assessid, a.remarks AS score, a.name AS title
                         FROM assesssubmit AS a
                         WHERE a.studname = '$lastName' AND EXISTS (
                            SELECT 1 FROM assessments AS assess
                            WHERE a.assessid = assess.id AND assess.subject = '$subject'
                        )";
    $assessmentsResult = mysqli_query($con, $assessmentsQuery);
    $assessmentsData = mysqli_fetch_all($assessmentsResult, MYSQLI_ASSOC);
    if ($assessmentsResult) {
      // Fetch data from the result set and structure it
      $assessmentsArr = array();
      foreach($assessmentsData as $row) {
          $assessment = array(
              "Activity" => (int)$row['title'],
              "Grade" => $row['score'],
          );
          // Add each assessment to the assessmentsArr array
          $assessmentsArr[] = $assessment;
      }
  
      // Create an array to hold the final result
      $assessmentsResult = array(
          "data" => $assessmentsArr
      );
  
      $assessmentsJSON = json_encode($assessmentsResult);
  
  }
    
    
  

    // Calculate activities average
 function gradeToValue($grade)
{
    switch (strtoupper($grade)) {
        case 'A':
            return 5.0;
        case 'B':
            return 4.0;
        case 'C':
            return 3.0;
        case 'D':
            return 2.0;
        case 'E':
            return 1.0;
        default:
            return 0.0; // Return 0.0 for unrecognized grades
    }
}
   function valueToGrade($value)
{
    if ($value >= 5.0) {
        return 'A';
    } elseif ($value >= 4.0) {
        return 'B';
    } elseif ($value >= 3.0) {
        return 'C';
    } elseif ($value >= 2.0) {
        return 'D';
    } elseif ($value >= 1.0) {
        return 'E';
    }
    else {
      return 'F';
    }
}

    // Calculate the activities average if there are activities data
    $activitiesTotal = 0;
    $activitiesCount = count($activitiesData);
    if ($activitiesCount > 0) {
        foreach ($activitiesData as $activity) {
            $activitiesTotal += gradeToValue($activity['score']);
        }
        $activitiesAverage = $activitiesTotal / $activitiesCount;
    } else {
        // Set default value for activities average if no data
        $activitiesAverage = 0;
    }

    // Calculate the assessments average if there are assessments data
    $assessmentsTotal = 0;
    $assessmentsCount = count($assessmentsData);
    if ($assessmentsCount > 0) {
        foreach ($assessmentsData as $assessment) {
            $assessmentsTotal += gradeToValue($assessment['score']);
        }
        $assessmentsAverage = $assessmentsTotal / $assessmentsCount;
    } else {
        // Set default value for assessments average if no data
        $assessmentsAverage = 0;
    }

    if ($activitiesCount > 0 && $assessmentsCount > 0) {
        $finalAverage = ($activitiesAverage + $assessmentsAverage) / 2;
    } else {
        // Set default value for final average if no data
        $finalAverage = 0;
    }

      $selectQuery = "SELECT * FROM assess WHERE lastname = '$lastName' AND subject = '$subject'";
      $result = mysqli_query($con, $selectQuery);
      if (mysqli_num_rows($result) > 0) {
          // Data for this subject already exists, fetch the values
          $row = mysqli_fetch_assoc($result);
          $initial = $row['initial'];
          $act = $row['act'];
          $ass = $row['ass'];
          $ave = $row['ave'];
          $final = $row['final'];
          $status = $row['status'];
      } else {
          // Data for this subject does not exist, insert a new row
          $act = $activitiesAverage; // Average of activities
          $ass = $assessmentsAverage; // Average of assessments
          $ave = $finalAverage; // Final average (average of activities and assessments)
          $initial = 'Ungraded';
          $final = 'Ungraded';
          $status = 'Pass';  
  }
  // Convert numeric averages to letters
    $activitiesAverageLetter = valueToGrade($activitiesAverage);
    $assessmentsAverageLetter = valueToGrade($assessmentsAverage);
    $finalAverageLetter = valueToGrade($finalAverage);
    }
    // Fetch past announcements from the database
    $query = "SELECT * FROM announcements ORDER BY created_at DESC";
    $annresult = mysqli_query($con, $query);

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

  <title><?php echo $lastName; ?>  | Progress</title>
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
        <h2><?php echo $subject;?> Progress</h2><br>
        <h3> <?php echo 'Last Name: ', $lastName; ?></h3><br><br>
        <h3>Activities</h3>
        <div>
          <a class="btn btn-primary <?php echo strtolower($subject) === 'Mathematics' ? 'active' : ''; ?>" href="./progress.php?lastname=<?php echo urlencode($lastName); ?>&subject=Mathematics">Mathematics</a>
          <a class="btn btn-primary <?php echo strtolower($subject) === 'English' ? 'active' : ''; ?>" href="./progress.php?lastname=<?php echo urlencode($lastName); ?>&subject=English">English</a>
          <a class="btn btn-primary <?php echo strtolower($subject) === 'Science' ? 'active' : ''; ?>" href="./progress.php?lastname=<?php echo urlencode($lastName); ?>&subject=Science">Science</a>
          <a class="btn btn-primary <?php echo strtolower($subject) === 'Filipino' ? 'active' : ''; ?>" href="./progress.php?lastname=<?php echo urlencode($lastName); ?>&subject=Filipino">Filipino</a>
          <a class="btn btn-primary <?php echo strtolower($subject) === 'Reading' ? 'active' : ''; ?>" href="./progress.php?lastname=<?php echo urlencode($lastName); ?>&subject=Reading">Reading</a>
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
                <td><?php echo htmlspecialchars("Activity {$activity['title']}"); ?></td>
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
        <form method="post" action="./update_progress.php">
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
              <td>        
                <select name="initial">
                  <option value="Ungraded" <?php echo $initial === 'Ungraded' ? 'selected' : ''; ?>>Ungraded</option>
                  <option value="A" <?php echo $initial === 'A' ? 'selected' : ''; ?>>A</option>
                  <option value="B" <?php echo $initial === 'B' ? 'selected' : ''; ?>>B</option>
                  <option value="C" <?php echo $initial === 'C' ? 'selected' : ''; ?>>C</option>
                  <option value="D" <?php echo $initial === 'D' ? 'selected' : ''; ?>>D</option>
                  <option value="E" <?php echo $initial === 'E' ? 'selected' : ''; ?>>E</option>
                </select>
            </td>

                <td><?php echo $activitiesAverageLetter; ?><input type="hidden" name="act" value="<?php echo $activitiesAverage; ?>"></td>
                <td><?php echo $assessmentsAverageLetter; ?><input type="hidden" name="ass" value="<?php echo $assessmentsAverage; ?>"></td>
                <td><?php echo $finalAverageLetter; ?><input type="hidden" name="ave" value="<?php echo $finalAverage; ?>"></td>
            <td>
              <select name="final">
               <option value="Ungraded" <?php echo $final === 'Ungraded' ? 'selected' : ''; ?>>Ungraded</option>
                <option value="A" <?php echo $final === 'A' ? 'selected' : ''; ?>>A</option>
                <option value="B" <?php echo $final === 'B' ? 'selected' : ''; ?>>B</option>
                <option value="C" <?php echo $final === 'C' ? 'selected' : ''; ?>>C</option>
                <option value="D" <?php echo $final === 'D' ? 'selected' : ''; ?>>D</option>
                <option value="E" <?php echo $final === 'E' ? 'selected' : ''; ?>>E</option>
                </select>
              </td>
              <td>
                <select name="status">
                <option value="Pass" <?php echo $status === 'Pass' ? 'selected' : ''; ?>>Pass</option>
                <option value="A" <?php echo $final === 'Fail' ? 'selected' : ''; ?>>Fail</option>
              </select>
              </td>
            </tr>
          </tbody>
        </table>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <br>      
        <br>  
      <div>
        <!-- Bar Graph -->
        <h4>Prediction Progress for Activities</h4>
        <div id="activityChart"></div>
      </div>

      <br><br>
        <h4>Prediction Progress for Assessments</h4>
        <div id="assessmentChart"></div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <div id="footer" class="footer">
    <script src="../../js/apexchart.js"></script>
    <script src="../../js/progress.js"></script>
    <p>
      <center>© 2023 Tutor House Inc.</center>
    </p>
  </div>

<script>
    // Function to render the chart
    function ichart(categories, scores, iid) {
        var options = {
            chart: {
                type: "line",
                height: 350,
                width: '100%',
                toolbar: {
                    show: true
                }
            },
            series: [{
                data: scores.map(scoreToValue),
            }],
            xaxis: {
                type: 'category',
                categories: categories, // Data on the x-axis
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        // Convert numerical values to corresponding grades
                        var grades = ['F','E', 'D', 'C', 'B', 'A'];
                        return grades[value - 1]; // Adjust the index to match the grades array
                    }
                }
            }
        };

        // Initialize and render the chart
        var chart = new ApexCharts(document.querySelector("#" + iid), options);
        chart.render();
    }




    $(document).ready(function(){
        // Fetch prediction data
        var predictionData = <?php echo $resultJSON; ?>;

        // Perform AJAX request to predict grades for activities
        $.ajax({
            url: 'http://127.0.0.1:8000/predict/',
            type: 'POST',
            data: JSON.stringify(predictionData),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                console.log('Activities Response:', response);

                // Extract Activity and Grade arrays from the response
                var activities = response.predictions.map(prediction => prediction.Activity);
                var grades = response.predictions.map(prediction => prediction.Grade);

                // Render the chart with extracted data for activities
                ichart(activities, grades, 'activityChart');
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        });

        // Fetch assessment data
        var assessmentData = <?php echo $assessmentsJSON; ?>;
        console.log(assessmentData);

        // Perform AJAX request to predict grades for assessments
        $.ajax({
            url: 'http://127.0.0.1:8000/predict/',
            type: 'POST',
            data: JSON.stringify(assessmentData),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                console.log('Assessments Response:', response);

                // Extract Assessment and Score arrays from the response
                var assessments = response.predictions.map(prediction => prediction.Activity);
                var scores = response.predictions.map(prediction => prediction.Grade);
                // Render the chart with extracted data for assessments
                ichart(assessments, scores, 'assessmentChart');
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        });
    });

    // Function to map scores to numerical values
    function scoreToValue(score) {
        switch (score) {
            case 'A': return 6;
            case 'B': return 5;
            case 'C': return 4;
            case 'D': return 3;
            case 'E': return 2;
            case 'F': return 1;
            default: return 0;
        }
    }

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