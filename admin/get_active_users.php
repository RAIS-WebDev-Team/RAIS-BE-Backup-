<?php

// ===================================================================
// STEP A: ADD THESE TWO LINES TO FORCE ERRORS TO DISPLAY
// ===================================================================
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config.php'; // Make sure this path is correct

// ===================================================================
// STEP B: ADD THIS CHECK TO VERIFY THE DATABASE CONNECTION
// ===================================================================
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define "active" as someone seen in the last 10 seconds.
$active_threshold = 15; // in seconds

// Query to count active users
$sql_active = "SELECT COUNT(id) AS active_count FROM users WHERE last_activity >= NOW() - INTERVAL ? SECOND";
$stmt_active = $conn->prepare($sql_active);
$stmt_active->bind_param("i", $active_threshold);
$stmt_active->execute();
$result_active = $stmt_active->get_result();
$active_row = $result_active->fetch_assoc();
$active_users = $active_row['active_count'];
$stmt_active->close();

// --- Calculate Total Users ---
$sql_total = "SELECT COUNT(id) AS total_count FROM users";
$result_total = $conn->query($sql_total);
$total_row = $result_total->fetch_assoc();
$total_users = $total_row['total_count'];

// Inactive users are the total minus the active ones
$inactive_users = $total_users - $active_users;

$conn->close();

// --- Return the data as JSON ---
// This is what the JavaScript on your admin page receives
header('Content-Type: application/json');
echo json_encode([
    'active_users' => $active_users,
    'inactive_users' => $inactive_users
]);
?>