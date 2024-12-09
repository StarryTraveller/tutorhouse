

<DOCTYPE !html>
  <html>

  <head>
    <!-- value="<?php echo $name; ?>" meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- bootstrap and css -->
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../photos/logocolor.png">

    <title> LMS | Teacher Info </title>

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
      <a href="../dashboards/teacher_dashboard.php" class="btn btn-primary my-4 my-sm-8">Back to Dasboard</a>
      <div class="container my-5"> <!--Container -->
        <h1 align="center">Tutor Information</h1><br>
        <form method="post"> <!--Form Method -->
          <div class="row">
            <div class="col">
              <label for="firstname">Last Name</label>
              <input type="text" class="form-control" placeholder="Last Name" name="lastname" autocomplete="off" value="<?php echo $lastname; ?>"readonly>
            </div>

            <div class="col">
              <label for="lastname">First Name</label>
              <input type="text" class="form-control" placeholder="First Name" name="firstname" autocomplete="off" value="<?php echo $firstname; ?>"readonly>
            </div>

            <div class="col">
              <label for="middlename">Middle Name</label>
              <input type="text" class="form-control" placeholder="Middle Name" name="middlename" autocomplete="off" value="<?php echo $middlename; ?>"readonly>
            </div>

            <div class="col">
              <label for="middlename">Suffix</label>
              <select class="form-control" placeholder="Suffix" name="suffix" readonly>
                <option <?php if ($suffix == 'None') echo 'selected'; ?>>None</option>
                <option <?php if ($suffix == 'Jr') echo 'selected'; ?>>Jr</option>
                <option <?php if ($suffix == 'Sr') echo 'selected'; ?>>Sr</option>
                <option <?php if ($suffix == 'II') echo 'selected'; ?>>II</option>
                <option <?php if ($suffix == 'III') echo 'selected'; ?>>III</option>
                <option <?php if ($suffix == 'IV') echo 'selected'; ?>>IV</option>
                <option <?php if ($suffix == 'V') echo 'selected'; ?>>V</option>
                <option <?php if ($suffix == 'VI') echo 'selected'; ?>>VI</option>
              </select>
            </div>

          </div><br>

          <div class="row">
            <div class="col">
              <label for="address">Home Address</label>
              <input type="text" class="form-control" placeholder="Full Address" name="address" autocomplete="off" style="width: 600px;" value="<?php echo $address; ?>"readonly>
            </div>

            <div class="col">
              <label for="barangay">Barangay</label>
              <input type="text" class="form-control" placeholder="Barangay" name="barangay" autocomplete="off" value="<?php echo $barangay; ?>"readonly>
            </div>

            <div class="col">
              <label for="city">City</label>
              <input type="text" class="form-control" placeholder="City" name="city" autocomplete="off" value="<?php echo $city; ?>"readonly>
            </div>

          </div><br>

          <div class="row">
            <div class="col">
              <label for="email">Email Address</label>
              <input type="email" class="form-control" placeholder="Email Address" name="email" autocomplete="off" value="<?php echo $email; ?>"readonly>
            </div>

            <div class="col">
              <label for="mobile">Mobile Number</label>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="(format: 09XXXXXXXX)" pattern="[0-9]{11}" value="<?php echo $phone; ?>"readonly>
            </div>

          </div><br>

          <div class="row">
            <div class="col">
              <label for="address">Date of Birth</label>
              <input type="date" class="form-control" placeholder="Full Address" name="birthdate" autocomplete="off" style="width: 600px;" value="<?php echo $birthdate; ?>"readonly>
            </div>

            <div class="col">
              <label for="age">Age</label>
              <input type="text" class="form-control" placeholder="Age" name="age" autocomplete="off" value="<?php echo $age; ?>"readonly>
            </div>

            <div class="col">
              <label for="gender">Gender</label>
              <select class="form-control" placeholder="Gender" name="gender" value="<?php echo $gender; ?>"readonly>
                <option <?php if ($gender == 'Select') echo 'selected'; ?>>Select</option>
                <option <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                <option <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                <option <?php if ($gender == 'Other') echo 'selected'; ?>>Other</option>
              </select>
            </div>
          </div><br>


          <br><br>
          <h5>LMS Account Information</h5>
          <div class="row">
            <div class="col">
              <label for="id">ID</label>
              <input type="text" class="form-control" placeholder="" name="id" autocomplete="off" value="<?php echo $id; ?>" readonly>
            </div>
            <div class="col">
              <label for="emailacc">Email for Account</label>
              <input type="text" class="form-control" placeholder="" name="email1" autocomplete="on" value="<?php echo $email; ?>" readonly>
            </div>
            <div class="col">
              <label for="password">Password</label>
              <input type="password" class="form-control" placeholder="Account Password" name="password" autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" value="<?php echo $password1; ?>">
            </div>
          </div>
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