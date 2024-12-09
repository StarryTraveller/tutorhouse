<?php

if (!isset($_SESSION['email']) || ($_SESSION['type'] !== 'admin')) {
    header("Location: ../login.php");
    exit();
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
    <link rel="icon" type="image/x-icon" href="../photos/logocolor.png">

    <title> LMS | Teacher List </title>


  </head>

  <body>
    <nav class="navbar navbar-light" style="background-color: #98c1d9;">
      <div class="container-fluid">
        <a class="navbar-brand" aria-disabled="true">
          <img src="../photos/logocolor.png" class="me-2" height="50" alt="Logo" />
          <small>Tutor House | LMS</small> </a>
        <a href="../logout.php" class="btn btn-primary my-2 my-sm-0">Logout</a>
      </div>
    </nav>
    <div class="container">
      <button class="btn btn-primary my-5"> <a href="../dashboards/admin_dashboard.php" class="text-light">Back to Dashboard</a><br></button>
      <button class="btn btn-success my-2 my-sm-0"> <a href="../crud/enrollteacher.php" class="text-light"><span>Enroll Teacher</span> </a>

      </button>

      <table class="table" style="border:5px solid black">
        <thead>
          <tr>
            <th scope="col">ID no.</th>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Email</th>

            <th scope="col">Operation</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $servername = "localhost";
          $username = "root";
          $password = "";
          $database = "tutordb";

          $con = mysqli_connect($servername, $username, $password, $database);


          $sql = "Select * from `tblteacherinfo`";
          $result = mysqli_query($con, $sql);
          if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
              $id = $row['id'];
              $lastname = $row['lastname'];
              $firstname = $row['firstname'];
              $email = $row['email'];


              echo '   <tr>
                <th scope="row">' . $id . '</th>
                <td>' . $lastname . '</td>
                <td>' . $firstname . '</td>
                <td>' . $email . '</td>
             
                <td>
                <button class="btn btn-primary"><a href="../crud/updateteacher.php? updateid=' . $id . '" class="text-light" >Update </a></button>
                <button class="btn btn-danger"><a href="../crud/deleteteacher.php? deleteid=' . $id . '" class="text-light">Delete </a></button>
                </td>
                </tr>';
            }
          }

          ?>





        </tbody>
      </table>

  </body>

  </html>