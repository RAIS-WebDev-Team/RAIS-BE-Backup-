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

// Active users are now defined by their 'Active' status.
$sql_active = "SELECT COUNT(id) AS active_count FROM users WHERE status = 'Active' AND role LIKE '%Client%'";
$result_active = $conn->query($sql_active);
$active_row = $result_active->fetch_assoc();
$active_users = $active_row['active_count'];

// --- Calculate Total Users (Clients only) ---
$sql_total = "SELECT COUNT(id) AS total_count FROM users WHERE role LIKE '%Client%'";
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
