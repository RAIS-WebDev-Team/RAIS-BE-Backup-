<?php
session_start();
require_once '../config.php';

header('Content-Type: application/json');

// Security Check: Ensure user is a logged-in admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || strpos($_SESSION['role'], 'Admin') === false) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit;
}

// Check if required data is sent via POST
if (isset($_POST['userId'], $_POST['firstName'], $_POST['lastName'], $_POST['email'])) {
    $userId = $_POST['userId'];
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);

    // Basic validation
    if (empty($userId) || empty($firstName) || empty($lastName) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
        exit;
    }

    // Prepare and execute the update statement
    $sql = "UPDATE users SET firstName = ?, lastName = ?, email = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssi", $firstName, $lastName, $email, $userId);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
            } else {
                // This can happen if the user saves without making any changes
                echo json_encode(['status' => 'success', 'message' => 'No changes were made.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to execute statement.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement.']);
    }
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Required data not provided.']);
}
?>
