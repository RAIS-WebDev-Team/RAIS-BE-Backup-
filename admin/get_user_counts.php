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
// Define "active" as someone seen in the last 15 seconds.
$active_threshold = 15;

// Get active user count
$sql_active = "SELECT COUNT(id) AS active_count FROM users WHERE last_activity >= NOW() - INTERVAL ? SECOND";
$stmt_active = $conn->prepare($sql_active);
$stmt_active->bind_param("i", $active_threshold);
$stmt_active->execute();
$result_active = $stmt_active->get_result();
$active_users = $result_active->fetch_assoc()['active_count'];
$stmt_active->close();

// Get total user count
$sql_total = "SELECT COUNT(id) AS total_count FROM users";
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
