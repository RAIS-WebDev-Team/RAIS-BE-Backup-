<?php
/**
 * Database configuration
 *
 * This file contains the settings for connecting to your database.
 * It provides both a mysqli connection object ($conn) and a PDO connection object ($pdo)
 * for compatibility across different parts of the application.
 */

// --- General Settings ---
// FIX: Replaced non-standard spaces with regular spaces to prevent a PHP parse error.
define('BASE_URL', sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
));

// --- Database Credentials ---
$servername = "localhost"; // Same as $host
$username = "root";
$password = "";
$dbname = "raisdb";
$charset = "utf8mb4";


// --- 1. Original mysqli Connection (for existing code) ---
// The script calling this file should handle connection errors.
$conn = new mysqli($servername, $username, $password, $dbname);


// --- 2. PDO Connection (for new features) ---
// Create connection object named $pdo
$dsn = "mysql:host=$servername;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
     // For a real-world application, you would log this error instead of displaying it.
     error_log("PDO Connection Error: " . $e->getMessage());
     // We will not 'die()' here. The calling script will check if $pdo was successfully created.
     $pdo = null;
}
?>

