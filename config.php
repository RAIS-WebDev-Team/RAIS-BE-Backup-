<?php
// config.php - Database Connection

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "raisdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
define('BASE_URL', sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
));
// Check connection
if ($conn->connect_error) {
    // If connection fails, stop the script and display an error.
    die("Connection failed: " . $conn->connect_error);
}
?>
