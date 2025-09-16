<?php
session_start();
header('Content-Type: application/json');
require_once '../config.php';

// Security Check: Ensure user is logged in and is an Admin
if (!isset($_SESSION['loggedin']) || strpos($_SESSION['role'], 'Admin') === false) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$action = $_REQUEST['action'] ?? null;
$response = ['success' => false, 'message' => 'Invalid action.'];

switch ($action) {
    case 'fetch':
        try {
            $stmt = $pdo->query("SELECT content_key, content_value FROM footer_content");
            // FETCH_KEY_PAIR is perfect for creating an associative array from two columns
            $data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            $response = ['success' => true, 'data' => $data];
        } catch (PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
        break;

    case 'update':
        if (isset($_POST['footerData'])) {
            $footerData = json_decode($_POST['footerData'], true);

            if (json_last_error() === JSON_ERROR_NONE) {
                try {
                    $pdo->beginTransaction();
                    $stmt = $pdo->prepare("UPDATE footer_content SET content_value = :value WHERE content_key = :key");

                    foreach ($footerData as $key => $value) {
                        $stmt->execute([':value' => $value, ':key' => $key]);
                    }
                    
                    $pdo->commit();
                    $response = ['success' => true, 'message' => 'Footer content updated successfully.'];

                } catch (PDOException $e) {
                    $pdo->rollBack();
                    $response['message'] = 'Database error on update: ' . $e->getMessage();
                }
            } else {
                $response['message'] = 'Invalid JSON data received.';
            }
        } else {
            $response['message'] = 'No footer data provided.';
        }
        break;
}

echo json_encode($response);
?>
