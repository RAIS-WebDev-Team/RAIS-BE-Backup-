<?php
// logout.php - Destroys the user's session and logs them out.

// Initialize the session.
session_start();

// Unset all of the session variables.
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to the homepage, which is one directory level up.
header("location: index.php");
exit;
?>
