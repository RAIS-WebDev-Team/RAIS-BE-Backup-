<?php
/**
 * API for Landing Page Hero Media Management
 *
 * This script handles all CRUD (Create, Read, Update, Delete) operations
 * for the hero_media table in the database.
 */

// --- Failsafe JSON Error Handling ---
ob_start(); // Start output buffering to catch any stray output

// This function will run at the end of the script, even on fatal errors.
register_shutdown_function(function () {
    $error = error_get_last();
    // If a fatal error occurred and no headers have been sent yet
    if ($error !== null && !headers_sent()) {
        http_response_code(500); // Internal Server Error
        header('Content-Type: application/json');
        // Clear the buffer of any HTML errors
        ob_end_clean();
        echo json_encode([
            'success' => false,
            'message' => "Fatal Server Error: " . $error['message'] . " in " . $error['file'] . " on line " . $error['line']
        ]);
        exit;
    }
    // If no errors, send the buffer content
    ob_end_flush();
});

// This function will catch any non-fatal PHP errors/warnings.
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// Explicitly turn off displaying startup errors as a fallback.
ini_set('display_errors', 0);
error_reporting(E_ALL);


// Start session
session_start();

// --- Robustly include config and check for PDO object ---
$configFile = __DIR__ . '/../config.php';

if (!file_exists($configFile)) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server Configuration Error: The config.php file could not be found.'
    ]);
    exit;
}

// Isolate the config file inclusion to catch any premature output (like a die() statement)
ob_start();
require_once $configFile;
$configOutput = ob_get_clean();

if (!isset($pdo)) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server Configuration Error: The database connection object ($pdo) was not created. Output from config: ' . trim($configOutput)
    ]);
    exit;
}


// --- Security Check: Ensure user is logged in and is an Admin ---
if (!isset($_SESSION['loggedin']) || strpos($_SESSION['role'], 'Admin') === false) {
    // If not authorized, send a JSON error response and exit.
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

// Determine the action from the request
$action = $_REQUEST['action'] ?? '';

header('Content-Type: application/json'); // Set header for all responses

try {
    switch ($action) {
        // --- ACTION: Fetch all media items ---
        case 'fetch':
            $stmt = $pdo->query("SELECT id, media_name, uploader, upload_date, file_path, is_active FROM hero_media ORDER BY upload_date DESC");
            $mediaItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $mediaItems]);
            break;

        // --- ACTION: Add a new media item ---
        case 'add':
            // Validation
            if (empty($_POST['mediaName']) || empty($_POST['uploaderName']) || empty($_FILES['mediaFile'])) {
                throw new Exception('Missing required fields.');
            }
            if ($_FILES['mediaFile']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('File upload error code: ' . $_FILES['mediaFile']['error']);
            }

            // Define upload directory and create if it doesn't exist
            $uploadDir = '../uploads/hero/';
            if (!is_dir($uploadDir)) {
                 // FIX: Set umask to ensure correct permissions are set on the new directory
                umask(0);
                if (!mkdir($uploadDir, 0777, true)) {
                     throw new Exception('Failed to create upload directory. Please check permissions.');
                }
            }

            // Create a unique filename to prevent overwrites
            $fileExtension = pathinfo($_FILES['mediaFile']['name'], PATHINFO_EXTENSION);
            $uniqueFilename = uniqid('hero_') . '.' . $fileExtension;
            $uploadFilePath = $uploadDir . $uniqueFilename;
            $dbFilePath = 'uploads/hero/' . $uniqueFilename; // Relative path for the database

            // Move the uploaded file
            if (!move_uploaded_file($_FILES['mediaFile']['tmp_name'], $uploadFilePath)) {
                throw new Exception('Failed to move uploaded file.');
            }

            // Insert into database
            $sql = "INSERT INTO hero_media (media_name, uploader, file_path) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['mediaName'], $_POST['uploaderName'], $dbFilePath]);

            echo json_encode(['success' => true, 'message' => 'Media added successfully.']);
            break;

        // --- ACTION: Delete a media item ---
        case 'delete':
            $id = $_POST['id'] ?? 0;
            if (!$id) throw new Exception('Invalid ID for deletion.');

            // First, get the file path to delete the actual file
            $stmt = $pdo->prepare("SELECT file_path FROM hero_media WHERE id = ?");
            $stmt->execute([$id]);
            $media = $stmt->fetch();

            if ($media && file_exists('../' . $media['file_path'])) {
                unlink('../' . $media['file_path']); // Delete the file from the server
            }

            // Then, delete the record from the database
            $stmt = $pdo->prepare("DELETE FROM hero_media WHERE id = ?");
            $stmt->execute([$id]);

            echo json_encode(['success' => true, 'message' => 'Media deleted successfully.']);
            break;

        // --- ACTION: Set a media item as active ---
        case 'set_active':
            $id = $_POST['id'] ?? 0;
            if (!$id) throw new Exception('Invalid ID to set active.');

            $pdo->beginTransaction();
            // Deactivate all other videos first
            $pdo->query("UPDATE hero_media SET is_active = 0");
            // Activate the selected video
            $stmt = $pdo->prepare("UPDATE hero_media SET is_active = 1 WHERE id = ?");
            $stmt->execute([$id]);
            $pdo->commit();

            echo json_encode(['success' => true, 'message' => 'Active media updated successfully.']);
            break;

        // --- ACTION: Update media details ---
        case 'edit':
            $id = $_POST['id'] ?? 0;
            $mediaName = $_POST['mediaName'] ?? '';
            $uploaderName = $_POST['uploaderName'] ?? '';
            if (!$id || !$mediaName || !$uploaderName) {
                throw new Exception('Invalid data for update. Missing ID, media name, or uploader name.');
            }
        
            $fileUploaded = isset($_FILES['mediaFile']) && $_FILES['mediaFile']['error'] === UPLOAD_ERR_OK;
        
            // If a new file is uploaded, handle all file operations
            if ($fileUploaded) {
                // Fetch the old file path to delete it after the update is successful
                $stmt = $pdo->prepare("SELECT file_path FROM hero_media WHERE id = ?");
                $stmt->execute([$id]);
                $oldMedia = $stmt->fetch();
                $oldFilePath = $oldMedia ? $oldMedia['file_path'] : null;
        
                // Define upload directory and ensure it exists
                $uploadDir = '../uploads/hero/';
                if (!is_dir($uploadDir)) {
                     if (!mkdir($uploadDir, 0777, true)) {
                        throw new Exception('Failed to create upload directory.');
                    }
                }
        
                // Create a new unique filename and path
                $fileExtension = pathinfo($_FILES['mediaFile']['name'], PATHINFO_EXTENSION);
                $uniqueFilename = uniqid('hero_') . '.' . $fileExtension;
                $uploadFilePath = $uploadDir . $uniqueFilename;
                $dbFilePath = 'uploads/hero/' . $uniqueFilename; // Relative path for the database
        
                // Move the newly uploaded file to the destination
                if (!move_uploaded_file($_FILES['mediaFile']['tmp_name'], $uploadFilePath)) {
                    throw new Exception('Failed to move the new uploaded file.');
                }
        
                // Update the database record with the new file path and details
                $sql = "UPDATE hero_media SET media_name = ?, uploader = ?, file_path = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$mediaName, $uploaderName, $dbFilePath, $id]);
        
                // After a successful DB update, delete the old file from the server
                if ($oldFilePath && file_exists('../' . $oldFilePath)) {
                    unlink('../' . $oldFilePath);
                }
            } else {
                // If no new file was uploaded, just update the text details in the database
                $sql = "UPDATE hero_media SET media_name = ?, uploader = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$mediaName, $uploaderName, $id]);
            }
            
            echo json_encode(['success' => true, 'message' => 'Media updated successfully.']);
            break;

        default:
            throw new Exception('Invalid action specified.');
            break;
    }
} catch (Exception $e) {
    // Catch any errors and return a JSON response
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>

