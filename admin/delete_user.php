<?php
require_once '../config.php';
$data = json_decode(file_get_contents('php://input'), true);
$response = ['status' => 'error'];
if (isset($data['userId'])) {
    $sql = "DELETE FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $data['userId']);
        if ($stmt->execute()) { $response['status'] = 'success'; }
        $stmt->close();
    }
}
$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>