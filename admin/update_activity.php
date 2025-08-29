<?php
session_start();

// Make sure this matches your session variable name (e.g., 'id', 'user_id')
if (isset($_SESSION['id'])) {
    
    require_once '../config.php'; 

    $userId = $_SESSION['id'];
    $sql = "UPDATE users SET last_activity = NOW() WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);

} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated.']);
}
?>