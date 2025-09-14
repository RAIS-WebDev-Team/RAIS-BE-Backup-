<?php
/**
 * API for About Page Content Management
 */

// --- Failsafe JSON Error Handling & Initialization ---
ob_start();
header('Content-Type: application/json');

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && !headers_sent()) {
        http_response_code(500);
        ob_end_clean();
        echo json_encode([
            'success' => false,
            'message' => "Fatal Server Error: " . $error['message'] . " in " . $error['file'] . " on line " . $error['line']
        ]);
        exit;
    }
    ob_end_flush();
});

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

session_start();
require_once '../config.php';

// --- Security Check ---
if (!isset($_SESSION['loggedin']) || strpos($_SESSION['role'], 'Admin') === false) {
    http_response_code(403); // Forbidden
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

$action = $_REQUEST['action'] ?? '';

try {
    switch ($action) {
        case 'fetch_all':
            $response = [
                'main' => null,
                'cards' => [],
                'content_blocks' => []
            ];
            $stmt_main = $pdo->query("SELECT title, description, media_path, media_type FROM about_main WHERE id = 1 LIMIT 1");
            if ($stmt_main) $response['main'] = $stmt_main->fetch(PDO::FETCH_ASSOC);

            $stmt_cards = $pdo->query("SELECT id, tab_title, card_title, content FROM about_cards ORDER BY sort_order ASC");
            if ($stmt_cards) $response['cards'] = $stmt_cards->fetchAll(PDO::FETCH_ASSOC);

            $stmt_blocks = $pdo->query("SELECT id, type, content, media_path, media_type FROM about_content_blocks ORDER BY sort_order ASC");
            if ($stmt_blocks) $response['content_blocks'] = $stmt_blocks->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'data' => $response]);
            break;

        case 'save_all':
            $pdo->beginTransaction();

            $title = $_POST['title'] ?? 'Default Title';
            $description = $_POST['description'] ?? '';
            $clear_media = $_POST['clear_media'] ?? '0';

            // Get old media path to delete if necessary
            $stmt_old = $pdo->query("SELECT media_path FROM about_main WHERE id = 1");
            $old_media_path = $stmt_old->fetchColumn();

            // Handle file upload
            if (isset($_FILES['mediaFile']) && $_FILES['mediaFile']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../uploads/about/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);
                
                $fileExtension = pathinfo($_FILES['mediaFile']['name'], PATHINFO_EXTENSION);
                $uniqueFilename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $fileExtension;
                $uploadFilePath = $uploadDir . $uniqueFilename;
                
                if (!move_uploaded_file($_FILES['mediaFile']['tmp_name'], $uploadFilePath)) {
                    throw new Exception('Failed to move uploaded file.');
                }
                
                $media_path = 'uploads/about/' . $uniqueFilename;
                $media_type = strpos($_FILES['mediaFile']['type'], 'video') !== false ? 'video' : 'image';

                // Delete old file since a new one was uploaded
                if ($old_media_path && file_exists('../' . $old_media_path)) {
                    unlink('../' . $old_media_path);
                }
                
                $stmt_main_update = $pdo->prepare("UPDATE about_main SET title = ?, description = ?, media_path = ?, media_type = ? WHERE id = 1");
                $stmt_main_update->execute([$title, $description, $media_path, $media_type]);
            } 
            // Handle media clearing
            elseif ($clear_media === '1') {
                if ($old_media_path && file_exists('../' . $old_media_path)) {
                    unlink('../' . $old_media_path);
                }
                $stmt_main_update = $pdo->prepare("UPDATE about_main SET title = ?, description = ?, media_path = NULL, media_type = 'image' WHERE id = 1");
                $stmt_main_update->execute([$title, $description]);
            }
            // If no file action, just update text
            else {
                $stmt_main_update = $pdo->prepare("UPDATE about_main SET title = ?, description = ? WHERE id = 1");
                $stmt_main_update->execute([$title, $description]);
            }

            // Update Cards
            $cards = json_decode($_POST['cards'] ?? '[]', true);
            $pdo->query("DELETE FROM about_cards"); 
            $stmt_card = $pdo->prepare("INSERT INTO about_cards (tab_title, card_title, content, sort_order) VALUES (?, ?, ?, ?)");
            foreach ($cards as $i => $card) {
                $stmt_card->execute([$card['tabTitle'], $card['cardTitle'], $card['content'], $i]);
            }
            
            // Update Content Blocks
            $content_blocks = json_decode($_POST['content_blocks'] ?? '[]', true);
            $pdo->query("DELETE FROM about_content_blocks");
            $stmt_block = $pdo->prepare("INSERT INTO about_content_blocks (type, content, sort_order) VALUES (?, ?, ?)");
            foreach ($content_blocks as $i => $block) {
                 $stmt_block->execute(['text', $block['content'], $i]);
            }

            $pdo->commit();
            echo json_encode(['success' => true, 'message' => 'About page updated successfully.']);
            break;

        default:
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid action specified.']);
            break;
    }
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

