<DOCTYPE !html>
  <html>

  <?php require "views/partials/head.php" ?>

  <body>
    <?php require "views/partials/nav.php" ?>

    <section class="vh-100" style="background-color: #3d5a80;">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
              <div class="card-body p-5 text-center">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                  <h3 class="mb-5">Sign in</h3>

                  <div class="form-outline mb-4">
                    <input type="email" id="typeEmailX-2" class="form-control form-control-lg" placeholder="Email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required />
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" id="typePasswordX-2" placeholder="Password" class="form-control form-control-lg" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required />
                  </div>

                  <p id="attempts"> Attempts Remaining: <?php echo isset($_SESSION['loginAttempts']) ? $_SESSION['loginAttempts'] : 5; ?></p>

                  <?php if (isset($_SESSION['loginAttempts']) && $_SESSION['loginAttempts'] == 0) { ?>
                    <div class="alert alert-info" role="alert" id="waitMessage">
                      Please wait 30 seconds before trying again.
                    </div>
                  <?php } ?>

                  <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger" role="alert" id="error">
                      <?php echo $error; ?>
                    </div>
                  <?php } ?>


                  <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                </form>
                <div class="form-text" style="text-align:center;">
                  <br>
                  <p><a href="./views/forgotpass.php">Forgot Password?</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script>
      var remainingAttempts = <?php echo isset($_SESSION['loginAttempts']) ? $_SESSION['loginAttempts'] : 5; ?>;
      var waitTime = <?php echo isset($_SESSION['waitTime']) ? ($_SESSION['waitTime'] - time()) : 0; ?>;
      var initialWaitTime = waitTime; // Store the initial wait time
      var waitMessage = document.getElementById('waitMessage');
      var attemptsElement = document.getElementById('attempts');
      var errorElement = document.getElementById('error');

      function countdown() {
        attemptsElement.textContent = 'Attempts Remaining: ' + remainingAttempts;

        if (remainingAttempts === 0) {
          waitMessage.style.display = 'block';
          errorElement.style.display = 'none';

          if (waitTime > 0) {
            var seconds = waitTime;
            var countdownInterval = setInterval(function() {
              if (seconds > 0) {
                waitMessage.textContent = 'Please wait ' + seconds + ' seconds before trying again.';
                seconds--;
              } else {
                clearInterval(countdownInterval);
                waitMessage.style.display = 'none';
                attemptsElement.textContent = 'Attempts Remaining: 5';
                remainingAttempts = 5;
                waitTime = initialWaitTime; // Reset the wait time to the initial value

                // Refresh the page to reset login attempts
                window.location.reload();
              }
            }, 1000);
          }
        }
      }

      // Call the countdown function on page load
      countdown();
    </script>

    <?php require "views/partials/footer.php" ?>
  </body>