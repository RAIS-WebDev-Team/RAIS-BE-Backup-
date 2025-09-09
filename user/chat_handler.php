<?php
// chat_handler.php - Handles AJAX requests for the user-facing chat.

// It is crucial to start the session before any other code that might use it.
session_start();

header('Content-Type: application/json');

try {
    // --- Path Verification Step ---
    $config_path = __DIR__ . '/../config.php';

    if (!file_exists($config_path)) {
        throw new Exception('Fatal Error: config.php not found. The script looked for it at: ' . $config_path);
    }
    if (!is_readable($config_path)) {
        throw new Exception('Fatal Error: config.php exists but is not readable. Please check file permissions.');
    }
    
    // If the file exists, we can safely include it.
    include_once $config_path;

    // --- Main Logic ---
    define('ADMIN_ID', 0);

    if (!isset($conn) || $conn->connect_error) {
        $error_msg = isset($conn) ? $conn->connect_error : 'The $conn variable was not found after including config.php.';
        throw new Exception('Database connection failed. Check your credentials in config.php. Details: ' . $error_msg);
    }

    if (!isset($_SESSION['id'])) {
        throw new Exception('User not authenticated. Please log in again.');
    }

    $userId = $_SESSION['id'];
    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    switch ($action) {
        case 'sendMessage':
            sendMessage($conn, $userId);
            break;
        case 'getMessages':
            getMessages($conn, $userId);
            break;
        default:
            throw new Exception('Invalid action specified.');
    }
    
    $conn->close();

} catch (Throwable $e) { // This will catch any error or exception
    // Log the detailed error if something unexpected happens in production
    error_log("Caught Exception/Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    
    // Send a clean JSON error back to the browser so it doesn't crash
    echo json_encode([
        'status' => 'error',
        'message' => 'A server error occurred. Please try again later.',
        'debug_info' => $e->getMessage()
    ]);
    exit;
}

/**
 * Inserts a message from a user into the database.
 */
function sendMessage($conn, $senderId) {
    $message = trim($_POST['message'] ?? '');
    if (empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Message cannot be empty.']);
        return;
    }

    $stmt = $conn->prepare("INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    
    $adminId = ADMIN_ID; // This is the fix: ADMIN_ID is now a variable.
    $stmt->bind_param("iis", $senderId, $adminId, $message);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    $stmt->close();
}

/**
 * Fetches the entire conversation history for a specific user with the Admin.
 */
function getMessages($conn, $userId) {
    $stmt = $conn->prepare(
        "SELECT id, sender_id, message, timestamp FROM chat_messages 
         WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
         ORDER BY timestamp ASC"
    );
    if (!$stmt) {
        throw new Exception("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $adminId = ADMIN_ID;
    $stmt->bind_param("iiii", $userId, $adminId, $adminId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    
    echo json_encode(['status' => 'success', 'messages' => $messages]);
    $stmt->close();
}

