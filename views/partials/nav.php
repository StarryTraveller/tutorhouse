<nav class="navbar navbar-light" style="background-color: #98c1d9;">
  <div class="container-fluid">
    <a class="navbar-brand" aria-disabled="true">
      <img src="./photos/logocolor.png" class="me-2" height="50" alt="Logo" />
      <small>Tutor House | LMS</small> </a>
    <?php
    if (isset($_SESSION['email'])) {
      echo '<a href="./logout.php" class="btn btn-primary my-2 my-sm-0"><span class="glyphicon glyphicon-log-out"></span>Logout</a>';
    }
    ?>
  </div>
</nav>