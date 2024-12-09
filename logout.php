<?php
session_start(); // Start session

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Prevent caching of the page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to the login page after logout
header("Location: login.php");
exit();
?>