<?php
require_once '../config.php';
$data = json_decode(file_get_contents('php://input'), true);
$response = ['status' => 'error', 'message' => 'Invalid data.'];

if (isset($data['firstName'], $data['lastName'], $data['email'], $data['status'])) {
    
    // Create a temporary, secure password for the new user.
    // They should change this later via a "forgot password" feature.
    $tempPassword = password_hash('password123', PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (firstName, lastName, email, status, password) VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $data['firstName'], $data['lastName'], $data['email'], $data['status'], $tempPassword);
        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'User added successfully.'];
        } else {
            // Check for duplicate email error
            if ($conn->errno === 1062) {
                $response['message'] = 'This email address is already in use.';
            } else {
                $response['message'] = 'Database execute failed: ' . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        $response['message'] = 'Database prepare failed: ' . $conn->error;
    }
    $conn->close();
}

header('Content-Type: application/json');
echo json_encode($response);
?>