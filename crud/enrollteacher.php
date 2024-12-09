<?php
session_start(); // Start session

// Prevent caching of the page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Check if the user is logged in
if (!isset($_SESSION['email']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../login.php"); // Redirect to login page if user is not logged in or doesn't have the student role
    exit();
}
require '../connection.php';

if (isset($_POST['submit'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $suffix = $_POST['suffix'];
    $address = $_POST['address'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $email1 = $_POST['email'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $password1 = $_POST['password'];
    $type = "teacher";

    // Insert into tblstudentinfo table
    $sql = "INSERT INTO tblteacherinfo (lastname, firstname, middlename, suffix, address, barangay, city, email, phone, birthdate, age, gender, password) VALUES ('$lastname', '$firstname', '$middlename', '$suffix', '$address', '$barangay', '$city', '$email', '$phone', '$birthdate', '$age', '$gender', '$password1')";

    $result = mysqli_query($con, $sql);

    if ($result) {
        // Data inserted successfully

        // Insert into tbladmin table
        $sql = "INSERT INTO tbladmin (email, password, type, level) VALUES ('$email1', '$password1', '$type', '$level')";

        $result = mysqli_query($con, $sql);

        if ($result) {
            // Data inserted successfully
            header('Location: ../studentinfo/teacherlist.php');
            exit();
        } else {
            die(mysqli_error($con));
        }
    } else {
        die(mysqli_error($con));
    }
}
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
    <link rel="icon" type="image/x-icon" href="./photos/logocolor.png">

    <title> LMS | Enroll </title>

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

    <div class="container">
      <a href="../dashboards/admin_dashboard.php" class="btn btn-primary my-4 my-sm-8">Back to Dashboard</a>
      <div class="container my-5"> <!--Container -->
        <h1 align="center">Employ A Teacher</h1><br>
        <form method="post"> <!--Form Method -->
          <div class="row">
            <div class="col">
              <label for="firstname">Last Name</label>
              <input type="text" class="form-control" placeholder="Last Name" name="lastname" autocomplete="off" required>
            </div>

            <div class="col">
              <label for="lastname">First Name</label>
              <input type="text" class="form-control" placeholder="First Name" name="firstname" autocomplete="off" required>
            </div>

            <div class="col">
              <label for="middlename">Middle Name</label>
              <input type="text" class="form-control" placeholder="Middle Name" name="middlename" autocomplete="off" required>
            </div>

            <div class="col">
              <label for="middlename">Suffix</label>
              <select class="form-control" placeholder="Suffix" name="suffix" required>
                <option selected>None</option>
                <option>Jr</option>
                <option>Sr</option>
                <option>II</option>
                <option>III</option>
                <option>IV</option>
                <option>V</option>
                <option>VI</option>
              </select>
            </div>

          </div><br>

          <div class="row">
            <div class="col">
              <label for="address">Home Address</label>
              <input type="text" class="form-control" placeholder="Full Address" name="address" autocomplete="off" style="width: 600px;" required>
            </div>

            <div class="col">
              <label for="barangay">Barangay</label>
              <input type="text" class="form-control" placeholder="Barangay" name="barangay" autocomplete="off" required>
            </div>

            <div class="col">
              <label for="city">City</label>
              <input type="text" class="form-control" placeholder="City" name="city" autocomplete="off" required>
            </div>

          </div><br>

          <div class="row">
            <div class="col">
              <label for="email">Email Address</label>
              <input type="email" class="form-control" placeholder="Email Address" name="email" autocomplete="off" required>
            </div>

            <div class="col">
              <label for="mobile">Mobile Number</label>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="(format: 09XXXXXXXXX)" pattern="[0-9]{11}" required>
            </div>

          </div><br>

          <div class="row">
            <div class="col">
              <label for="address">Date of Birth</label>
              <input type="date" class="form-control" placeholder="Full Address" name="birthdate" autocomplete="off" style="width: 600px;" required>
            </div>

            <div class="col">
              <label for="age">Age</label>
              <input type="text" class="form-control" placeholder="Age" name="age" autocomplete="off" required>
            </div>

            <div class="col">
              <label for="gender">Gender</label>
              <select class="form-control" placeholder="Gender" name="gender" required>
                <option selected>Select</option>
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
              </select>
            </div>
          </div><br>
          <br>
          <h5>LMS Account Information</h5>
          <div class="row">
            <div class="col">
              <label for="id">ID</label>
              <input type="text" class="form-control" placeholder="" name="id" autocomplete="off" readonly required>
            </div>
            <div class="col">
              <label for="emailacc">Email for Account</label>
              <input type="text" class="form-control" placeholder="" name="email1" autocomplete="on" readonly required>
            </div>
            <div class="col">
              <label for="password">Password</label>
              <input type="password" class="form-control" placeholder="Account Password" name="password" autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            </div>
          </div>
          <br><button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
      </div>
    </div>

    <div id="footer" class="footer">
      <p>
        <center>© 2023 Tutor House Inc.</center>
      </p>
    </div>
  </body>

  </html>