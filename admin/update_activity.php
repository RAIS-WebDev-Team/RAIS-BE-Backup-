<?php
session_start();

// This script should only run if a user is logged in.
// We use 'id' as it's more specific than 'loggedin'.
if (isset($_SESSION['id'])) {
    
    require_once '../config.php'; 

    $userId = $_SESSION['id'];
    // Update the last_activity timestamp for the current user to NOW()
    $sql = "UPDATE users SET last_activity = NOW() WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();

    // Send a success response back to the JavaScript fetch call
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);

} else {
    // If no user is logged in, send an error response
    header('Content-Type: application/json');
    http_response_code(401); // Unauthorized
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated.']);
}
?>
