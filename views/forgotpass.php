<?php
require_once '../connection.php';
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the values from the form
    $email = $_POST['email'];
    $name = $_POST['name'];


    // Prepare and execute the SQL query to insert data into the 'ticket' table
    $stmt = $con->prepare("INSERT INTO ticket (email, name) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $name);

    if ($stmt->execute()) {
        // Redirect to another page after successful submission
        header("Location: success.php");
        exit();
    } else {
        // Handle any errors during database insertion (optional)
        echo "Error: " . $con->error;
    }

    // Close the database connection
    $stmt->close();
    $con->close();
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
  <link rel="icon" href="../photos/logocolor.png">

  <title> LMS | Submit A Ticket </title>
</head>

  <body>
    <nav class="navbar navbar-light" style="background-color: #98c1d9;">
      <div class="container-fluid">
        <a class="navbar-brand" aria-disabled="true">
          <img src="../photos/logocolor.png" class="me-2" height="50" alt="Logo" />
          <small>Tutor House | LMS</small> </a>
        <?php
        if (isset($_SESSION['email'])) {
          echo '<a href="../logout.php" class="btn btn-primary my-2 my-sm-0"><span class="glyphicon glyphicon-log-out"></span>Logout</a>';
        }
        ?>
      </div>
    </nav>

    <section class="vh-100" style="background-color: #3d5a80;">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
              <div class="card-body p-5 text-center">
                <form action="./forgotpass.php" method="POST">
                  <h3 class="mb-5">Reset your Password</h3>

                  <div class="form-outline mb-4">
                    <label for="email">Email:</label>
                    <input type="email" id="typeEmailX-2" class="form-control form-control-lg" placeholder="Email" name="email" required> 
                  </div>

                  <div class="form-outline mb-4">
                    <label for="email">Full Name:</label>
                    <input type="text" class="form-control" placeholder="Full Name" name="name" autocomplete="off" required>
                  </div>

                  <button class="btn btn-success btn-lg btn-block" type="submit">Reset</button>
                </form>
                <br>
               <a href= "../login.php"><button class="btn btn-primary" type="submit">Back to Login</button></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>



      <div id="footer" class="footer">
        <p>
          <center>© 2023 Tutor House Inc.</center>
        </p>
      </div>
  </body>
</html>