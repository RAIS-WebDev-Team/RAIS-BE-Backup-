<?php
// -----------------------------------------------------------------
// File: process-reset-password.php (New File)
// This script handles the form submission from reset-password.php.
// It validates the new password and updates the database.
// -----------------------------------------------------------------

// --- Ensure the script is accessed via a POST request ---
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('Invalid request method. This page cannot be accessed directly.');
}

// --- Basic Password Validation ---
if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters long.");
}
if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter.");
}
if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number.");
}
if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords do not match. Please go back and try again.");
}

// --- Hash the new password for secure storage ---
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// --- Get and hash the token from the hidden form field ---
$token = $_POST["token"];
$token_hash = hash("sha256", $token);

// --- Include database connection ---
require_once 'db_connect.php';

// --- Find the user by the token hash again for final verification ---
$sql = "SELECT * FROM users WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("Token not found or invalid.");
}

// --- Final check to ensure the token has not expired ---
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired. Please request a new reset link.");
}

// --- Update the user's password and clear the reset token fields ---
// Setting the token fields to NULL prevents the same link from being reused.
$sql = "UPDATE users
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $password_hash, $user["id"]);
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
      
          body { font-family: 'Poppins', sans-serif; }
        .video-bg { position: fixed; top: 0; left: 0; min-width: 100%; min-height: 100%; object-fit: cover; z-index: -2; filter: blur(2px) brightness(0.8); }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: -1; }
        .card { max-width: 400px; margin: 5rem auto; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .btn-primary { background-color: #0C470C; border-color: #0C470C; }
        .btn-primary:hover { background-color: #106210; border-color: #106210; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="card text-center">
        <h2 class="mb-3">Password Updated!</h2>
        <p>Your password has been reset successfully. You can now log in with your new password.</p>
        <a href="login.php" class="btn btn-primary mt-3">Go to Login</a>
    </div>
</body>
</html>
