<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the home page or login page
header("Location: /hospital/index.php"); // Use a relative URL
exit();
?>
