<?php
// Suppress errors from being displayed in the output
ini_set('display_errors', 0);
error_reporting(0);

session_start();
require_once '../config.php';

$response = ['status' => 'error', 'message' => 'Failed to get statuses.'];

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'Super Admin') {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

// Path to the session files directory. This might need adjustment based on your server config.
$sessionPath = session_save_path();
if (empty($sessionPath)) {
    // A common fallback if the path isn't explicitly set in php.ini
    $sessionPath = '/tmp'; 
}

$adminStatuses = [];
$sql = "SELECT id FROM users WHERE role LIKE '%Admin%'";
if ($result = $conn->query($sql)) {
    while ($admin = $result->fetch_assoc()) {
        $adminId = $admin['id'];
        $adminStatuses[$adminId] = ['is_online' => false];
    }
    $result->free();
}

// Iterate through all session files
foreach (glob($sessionPath . '/sess_*') as $file) {
    // Use a try-catch block to handle potential issues with session data
    try {
        $sessionData = file_get_contents($file);
        if ($sessionData === false) {
            continue; // Skip if file can't be read
        }
        
        // Temporarily switch to the session being read
        $backupSession = $_SESSION;
        session_decode($sessionData);
        
        // Check if it's a logged-in admin
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['id']) && isset($adminStatuses[$_SESSION['id']])) {
            $adminStatuses[$_SESSION['id']]['is_online'] = true;
        }

        // Restore the original session
        $_SESSION = $backupSession;
    } catch (Exception $e) {
        // In case of a session_decode error, restore session and continue
        if (isset($backupSession)) {
            $_SESSION = $backupSession;
        }
        continue;
    }
}


$response['status'] = 'success';
$response['message'] = 'Statuses fetched successfully.';
$response['data'] = $adminStatuses;

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>

