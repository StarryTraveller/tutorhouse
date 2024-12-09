<!DOCTYPE html>
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
        <!-- Your navigation content goes here -->
    </nav>
    <section class="vh-100" style="background-color: #3d5a80;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <!-- Your success message here -->
                            <h3 class="mb-5">Ticket for password reset submitted!</h3>
                            <p>Wait for an admin to answer it and expect an email within 24 hours.</p>
                            <p>For faster response, please message us on Facebook Messenger.</p>

                            <!-- JavaScript code for redirecting after 10 seconds -->
                            <script>
                                // Function to redirect to the login page
                                function redirectToLoginPage() {
                                    window.location.href = "../login.php";
                                }

                                // Wait for 10 seconds and then call the redirect function
                                setTimeout(redirectToLoginPage, 10000);
                            </script>
                            
                            <!-- Additional text for redirecting message -->
                            <p>Redirecting to the login page in 10 seconds...</p>
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
