<?php
// --- SESSION AND SECURITY CHECK ---
session_start();
require_once '../config.php'; // Ensure this path is correct

// Only allow access if the user is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || strpos($_SESSION['role'], 'Admin') === false) {
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'Access denied']);
    exit;
}

// --- LOGIC ---
// Active users are now defined by their 'Active' status.
$sql_active = "SELECT COUNT(id) AS active_count FROM users WHERE status = 'Active' AND role LIKE '%Client%'";
$result_active = $conn->query($sql_active);
$active_users = $result_active->fetch_assoc()['active_count'];

// Get total user count for clients only
$sql_total = "SELECT COUNT(id) AS total_count FROM users WHERE role LIKE '%Client%'";
$result_total = $conn->query($sql_total);
$total_users = $result_total->fetch_assoc()['total_count'];

$conn->close();

// Calculate inactive users
$inactive_users = $total_users - $active_users;

// Set the content type header to JSON and output the data
header('Content-Type: application/json');
echo json_encode([
    'active_users' => $active_users,
    'inactive_users' => $inactive_users
]);
?>
