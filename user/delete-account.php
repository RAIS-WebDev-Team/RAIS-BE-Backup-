<?php
session_start();
include_once '../config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['id'];
    $password = $_POST['password'];

    // Fetch user's current hashed password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Verify the password for confirmation
        if (password_verify($password, $user['password'])) {
            // Delete the user account
            $deleteStmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $deleteStmt->bind_param("i", $userId);

            if ($deleteStmt->execute()) {
                // Log the user out by destroying the session
                session_unset();
                session_destroy();
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to delete account.']);
            }
            $deleteStmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Incorrect password.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User not found.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
