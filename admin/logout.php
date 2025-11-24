<?php
session_start(); // Find the current session
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session completely

// Redirect back to the login page
header("Location: login.php");
exit;
?>