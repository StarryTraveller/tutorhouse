<?php
session_start(); // Start session

// Prevent caching of the page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Check if the user is logged in
if (!isset($_SESSION['email']) || $_SESSION['type'] !== 'teacher') {
	header("Location: ../login.php"); // Redirect to login page if user is not logged in or doesn't have the teacher role
	exit();
}

require '../lms/teacher/remarklist.php';
require '../lms/teacher/remarks.php';
require '../lms/teacher/tutactivities.php';
require '../lms/teacher/tutassesments.php';
require '../lms/teacher/tutlessons.php';
require '../lms/teacher/tutquizzes.php';