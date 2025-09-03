<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id']) || !isset($data['status'])) {
        echo json_encode(['success' => false, 'message' => 'Missing ID or status.']);
        exit;
    }

    $id = intval($data['id']);
    $status = $data['status'];
    $allowed_statuses = ['Approved', 'Cancelled'];

    if (!in_array($status, $allowed_statuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status provided.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE client_applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Status updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Application not found or status already updated.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
