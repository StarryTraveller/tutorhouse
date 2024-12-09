<?php
require_once '../../connection.php';
session_start();
if (!isset($_SESSION['email']) || ($_SESSION['type'] !== 'teacher' && $_SESSION['type'] !== 'admin')) {
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
    <link rel="stylesheet" href="../../bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" type="image/x-icon" href="../../photos/logocolor.png">

    <title> LMS | Student List </title>

    <nav class="navbar navbar-light" style="background-color: #98c1d9;">
      <div class="container-fluid">
        <a class="navbar-brand" aria-disabled="true">
          <img src="../../photos/logocolor.png" class="me-2" height="50" alt="Logo" />
          <small>Tutor House | LMS</small> </a>
        <a href="../../logout.php" class="btn btn-primary my-2 my-sm-0">Logout</a>
      </div>
    </nav>
  </head>

  <body>

    <div class="container">
      <button class="btn btn-primary my-5"> <a href="../dashboards/admin_dashboard.php" class="text-light">Back to Dashboard</a><br></button>

      <table class="table" style="border:5px solid black">
        <thead>
          <tr>
            <th scope="col">ID no.</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Grade Level</th>
            <th scope="col">View Information</th>
          </tr>
        </thead>
        <tbody>

          <?php
          require '../../connection.php';


          $sql = "Select * from `tblstudentinfo`";
          $result = mysqli_query($con, $sql);
          if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
              $id = $row['id'];
              $firstname = $row['firstname'];
              $lastname = $row['lastname'];
              $level = $row['level'];

              echo '   <tr>
                <th scope="row">' . $id . '</th>
                <td>' . $firstname . '</td>
                <td>' . $lastname . '</td>
                <td>' . $level . '</td>
                <td>
                <button class="btn btn-success"><a href="../../studentinfo/infoview.php? id=' . $id . '" class="text-light" >View Info </a></button>
              
                </td>
                </tr>';
            }
          }

          ?>





        </tbody>
      </table>

  </body>

  </html>