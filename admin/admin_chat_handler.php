<?php
// admin_chat_handler.php - Handles AJAX requests for the admin chat panel.

session_start();
include_once '../config.php'; // Ensure this path is correct

// Check for admin privileges here if you have a role system
// For example: if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { ... exit; }

define('ADMIN_ID', 0);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'getConversations':
        getConversations($conn);
        break;
    case 'getMessages':
        getMessages($conn);
        break;
    case 'sendMessage':
        sendMessage($conn);
        break;
    case 'deleteConversation':
        deleteConversation($conn);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
        break;
}

$conn->close();

/**
 * Fetches a list of active user conversations.
 */
function getConversations($conn) {
    // This query gets the latest message for each conversation to display
    $query = "
        SELECT u.id, u.firstName, u.lastName, u.profileImage
        FROM users u
        JOIN (
            SELECT DISTINCT sender_id 
            FROM chat_messages 
            WHERE receiver_id = ? AND is_archived_by_admin = 0
        ) AS active_chats ON u.id = active_chats.sender_id
        ORDER BY (SELECT MAX(timestamp) FROM chat_messages WHERE sender_id = u.id) DESC
    ";
    
    $stmt = $conn->prepare($query);
    $adminId = ADMIN_ID;
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $conversations = [];
    while ($row = $result->fetch_assoc()) {
        $conversations[] = $row;
    }
    
    echo json_encode(['status' => 'success', 'conversations' => $conversations]);
    $stmt->close();
}


/**
 * Fetches messages for a specific user conversation.
 */
function getMessages($conn) {
    $userId = $_POST['userId'] ?? 0;
    if ($userId === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user ID.']);
        return;
    }
    
    $stmt = $conn->prepare(
        "SELECT id, sender_id, message, timestamp FROM chat_messages 
         WHERE ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?))
         AND is_archived_by_admin = 0
         ORDER BY timestamp ASC"
    );
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

/**
 * Sends a message from the admin to a user.
 */
function sendMessage($conn) {
    $receiverId = $_POST['receiver_id'] ?? 0;
    $message = trim($_POST['message'] ?? '');

    if ($receiverId === 0 || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid recipient or empty message.']);
        return;
    }

    $stmt = $conn->prepare("INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $adminId = ADMIN_ID;
    $stmt->bind_param("iis", $adminId, $receiverId, $message);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send message.']);
    }
    $stmt->close();
}

/**
 * Archives a conversation, effectively deleting it from the admin view.
 */
function deleteConversation($conn) {
    $userId = $_POST['userId'] ?? 0;
    if ($userId === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user ID.']);
        return;
    }

    $stmt = $conn->prepare(
        "UPDATE chat_messages SET is_archived_by_admin = 1 
         WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)"
    );
    $adminId = ADMIN_ID;
    $stmt->bind_param("iiii", $userId, $adminId, $adminId, $userId);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete conversation.']);
    }
    $stmt->close();
}
