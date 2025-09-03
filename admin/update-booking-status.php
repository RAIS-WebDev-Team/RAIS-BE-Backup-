<?php
// admin/update-booking-status.php

session_start();
include_once '../config.php';
header('Content-Type: application/json');

// Admin authentication check
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$action = $data['action'] ?? null;
$bookingId = $data['bookingId'] ?? null;
$newStatus = $data['newStatus'] ?? null;

if (!$action || !$bookingId) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
    exit;
}

// Extract numeric ID and table type from bookingId (e.g., 'BK-001' or 'FL-002')
$id_prefix = substr($bookingId, 0, 3);
$id = (int) substr($bookingId, 3);
$table = '';
$response = ['success' => false];

if ($id_prefix === 'BK-') {
    $table = 'consultations';
} elseif ($id_prefix === 'FL-') {
    $table = 'flights';
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid Booking ID format.']);
    exit;
}

if ($id === 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid numeric ID.']);
    exit;
}


switch ($action) {
    case 'update_status':
        if ($table === 'consultations' && in_array($newStatus, ['Approved', 'Cancelled'])) {
            $conn->begin_transaction();
            try {
                // Update consultation status
                $sql_update = "UPDATE consultations SET status = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param('si', $newStatus, $id);
                $stmt_update->execute();
                
                // Get user_id for notification
                $sql_user = "SELECT user_id, consultation_date FROM consultations WHERE id = ?";
                $stmt_user = $conn->prepare($sql_user);
                $stmt_user->bind_param('i', $id);
                $stmt_user->execute();
                $result_user = $stmt_user->get_result();
                if ($user_row = $result_user->fetch_assoc()) {
                    $user_id = $user_row['user_id'];
                    $consultation_date = date('F j, Y', strtotime($user_row['consultation_date']));
                    
                    // Create notification message
                    $message = "Your consultation scheduled for {$consultation_date} has been {$newStatus}.";
                    
                    // Insert notification
                    $sql_notif = "INSERT INTO notifications (user_id, message, type) VALUES (?, ?, 'consultation_status')";
                    $stmt_notif = $conn->prepare($sql_notif);
                    $stmt_notif->bind_param('is', $user_id, $message);
                    $stmt_notif->execute();
                }
                
                $conn->commit();
                $response = ['success' => true];

            } catch (mysqli_sql_exception $exception) {
                $conn->rollback();
                $response['message'] = 'Transaction failed: ' . $exception->getMessage();
            }
        } else {
             $response['message'] = 'Invalid status or table for update.';
        }
        break;

    case 'delete_consultation':
        if ($table === 'consultations') {
            $sql = "DELETE FROM consultations WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                $response = ['success' => true];
            } else {
                $response['message'] = 'Database delete failed.';
            }
            $stmt->close();
        }
        break;
        
    case 'delete_flight':
        if ($table === 'flights') {
            $sql = "DELETE FROM flights WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                $response = ['success' => true];
            } else {
                $response['message'] = 'Database delete failed.';
            }
            $stmt->close();
        }
        break;

    default:
        $response['message'] = 'Invalid action specified.';
        break;
}

$conn->close();
echo json_encode($response);
?>

