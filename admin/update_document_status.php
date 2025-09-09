<?php
// update_document_status.php
// This script handles updating a document's status and creating a notification for the user.

session_start();
require_once '../config.php';

// --- CHECK IF ADMIN IS LOGGED IN ---
// Note: You should implement a proper role-based access control system.
// This is a basic check assuming a 'role' is stored in the session.
if (!isset($_SESSION['loggedin']) /* || $_SESSION['role'] !== 'admin' */) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$action = $input['action'] ?? null;
$docId = $input['docId'] ?? null;
$newStatus = $input['newStatus'] ?? null; // e.g., 'Approved' or 'Cancelled'

if (!$action || !$docId) {
    echo json_encode(['success' => false, 'message' => 'Invalid input provided.']);
    exit;
}

// Start a database transaction to ensure all operations succeed or none do.
$conn->begin_transaction();

try {
    // --- Step 1: Get document details (user_id, file_name) before updating ---
    $userId = null;
    $fileName = null;
    $stmt_doc_details = $conn->prepare("SELECT user_id, file_name FROM user_documents WHERE id = ?");
    $stmt_doc_details->bind_param("i", $docId);
    $stmt_doc_details->execute();
    $result_doc_details = $stmt_doc_details->get_result();
    if ($doc = $result_doc_details->fetch_assoc()) {
        $userId = $doc['user_id'];
        $fileName = $doc['file_name'];
    }
    $stmt_doc_details->close();

    // If the document doesn't exist, we can't proceed.
    if (!$userId || !$fileName) {
        throw new Exception('Document not found in the database.');
    }

    if ($action === 'update_status' && $newStatus) {
        // --- Step 2: Update the document's status in the database ---
        $stmt_update = $conn->prepare("UPDATE user_documents SET status = ? WHERE id = ?");
        $status_for_db = strtolower($newStatus); // Store status as lowercase (e.g., 'approved')
        $stmt_update->bind_param("si", $status_for_db, $docId);
        if (!$stmt_update->execute()) {
            throw new Exception('Database update failed: ' . $stmt_update->error);
        }
        $stmt_update->close();

        // --- Step 3: Create a notification for the user ---
        $message = "Your document '" . htmlspecialchars($fileName) . "' has been " . htmlspecialchars($newStatus) . ".";
        $type = 'document_' . $status_for_db; // e.g., 'document_approved'
        $link = 'documents.php'; // Link for the user to check their documents page

        $stmt_notify = $conn->prepare("INSERT INTO notifications (user_id, message, type, link) VALUES (?, ?, ?, ?)");
        $stmt_notify->bind_param("isss", $userId, $message, $type, $link);
        if (!$stmt_notify->execute()) {
            throw new Exception('Failed to create notification: ' . $stmt_notify->error);
        }
        $stmt_notify->close();

    } elseif ($action === 'delete_document') {
        // --- Handle document deletion ---
        // Note: You might want to also unlink the physical file from your server here.
        $stmt_delete = $conn->prepare("DELETE FROM user_documents WHERE id = ?");
        $stmt_delete->bind_param("i", $docId);
        if (!$stmt_delete->execute()) {
            throw new Exception('Database delete failed: ' . $stmt_delete->error);
        }
        $stmt_delete->close();
        // You could create a "document deleted" notification here as well if desired.

    } else {
        throw new Exception('The specified action is not valid.');
    }

    // If all steps were successful, commit the changes to the database.
    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Action completed successfully.']);

} catch (Exception $e) {
    // If any step failed, roll back all database changes.
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}

$conn->close();
?>
