<?php
// user/process-consultation.php

session_start();
include_once '../config.php';
header('Content-Type: application/json');

// Ensure user is logged in
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$userId = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);

$date = $data['date'] ?? null;
$time = $data['time'] ?? null;
$notes = $data['notes'] ?? '';
$facebookLink = $data['facebookLink'] ?? '';

// Basic validation
if (!$date || !$time || !$facebookLink) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

// Start transaction for atomicity
$conn->begin_transaction();

try {
    // 1. Insert the consultation booking
    $sql_insert = "INSERT INTO consultations (user_id, consultation_date, consultation_time, notes, facebook_link, status) VALUES (?, ?, ?, ?, ?, 'Pending')";
    $stmt_insert = $conn->prepare($sql_insert);
    if (!$stmt_insert) {
        throw new Exception("Prepare failed (insert): " . $conn->error);
    }
    $stmt_insert->bind_param("issss", $userId, $date, $time, $notes, $facebookLink);
    if (!$stmt_insert->execute()) {
        throw new Exception("Execute failed (insert): " . $stmt_insert->error);
    }
    $stmt_insert->close();

    // 2. Create the "Pending" notification for the user
    $consultation_date_formatted = date('F j, Y', strtotime($date));
    $message = "Your consultation for {$consultation_date_formatted} has been submitted and is now pending review.";
    
    $sql_notif = "INSERT INTO notifications (user_id, message, type) VALUES (?, ?, 'consultation_status')";
    $stmt_notif = $conn->prepare($sql_notif);
     if (!$stmt_notif) {
        throw new Exception("Prepare failed (notif): " . $conn->error);
    }
    $stmt_notif->bind_param('is', $userId, $message);
    if (!$stmt_notif->execute()) {
        throw new Exception("Execute failed (notif): " . $stmt_notif->error);
    }
    $stmt_notif->close();

    // If all queries were successful, commit the transaction
    $conn->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // If any query fails, roll back the entire transaction
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?>

