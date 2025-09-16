<?php
session_start();
header('Content-Type: application/json');

require_once '../config.php';

// --- Helper Functions ---
function send_json_response($success, $message, $data = null) {
    $response = ['success' => $success, 'message' => $message];
    if ($data !== null) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit;
}

function handle_file_upload($file_key, $partner_id, $type) {
    if (!isset($_FILES[$file_key]) || $_FILES[$file_key]['error'] != UPLOAD_ERR_OK) {
        return null; // No file uploaded or an error occurred
    }

    $upload_dir = '../uploads/partners/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_info = pathinfo($_FILES[$file_key]['name']);
    $file_extension = strtolower($file_info['extension']);
    $safe_filename = $type . '_' . $partner_id . '_' . time() . '.' . $file_extension;
    $upload_path = $upload_dir . $safe_filename;

    if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $upload_path)) {
        // Return path relative to the website root
        return 'uploads/partners/' . $safe_filename;
    }

    return false; // Upload failed
}

// --- Security Check ---
if (!isset($_SESSION['loggedin']) || strpos($_SESSION['role'], 'Admin') === false) {
    send_json_response(false, 'Unauthorized access.');
}

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'fetch':
        try {
            $stmt = $pdo->query("SELECT * FROM partners ORDER BY id ASC");
            $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);
            send_json_response(true, 'Partners fetched successfully.', $partners);
        } catch (PDOException $e) {
            send_json_response(false, 'Database error: ' . $e->getMessage());
        }
        break;

    case 'add':
        try {
            $pdo->beginTransaction();

            $sql = "INSERT INTO partners (name, website_link) VALUES (:name, :website_link)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $_POST['name'] ?? '',
                ':website_link' => $_POST['website_link'] ?? ''
            ]);
            $partner_id = $pdo->lastInsertId();

            $logo_path = handle_file_upload('logoFile', $partner_id, 'logo');
            $bg_image_path = handle_file_upload('bgImageFile', $partner_id, 'bg');

            if ($logo_path === false || $bg_image_path === false) {
                $pdo->rollBack();
                send_json_response(false, 'Failed to upload one or more images.');
            }

            $update_sql = "UPDATE partners SET logo_path = :logo_path, background_image_path = :bg_image_path WHERE id = :id";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([
                ':logo_path' => $logo_path,
                ':bg_image_path' => $bg_image_path,
                ':id' => $partner_id
            ]);

            $pdo->commit();
            send_json_response(true, 'Partner added successfully.');

        } catch (PDOException $e) {
            $pdo->rollBack();
            send_json_response(false, 'Database error: ' . $e->getMessage());
        }
        break;

    case 'update':
         try {
            $partner_id = $_POST['id'] ?? null;
            if (!$partner_id) {
                send_json_response(false, 'Partner ID is missing.');
            }

            // Fetch old paths to delete files if new ones are uploaded
            $stmt = $pdo->prepare("SELECT logo_path, background_image_path FROM partners WHERE id = :id");
            $stmt->execute([':id' => $partner_id]);
            $old_paths = $stmt->fetch(PDO::FETCH_ASSOC);

            $logo_path = $old_paths['logo_path'];
            $bg_image_path = $old_paths['background_image_path'];

            $new_logo_path = handle_file_upload('logoFile', $partner_id, 'logo');
            if ($new_logo_path) {
                if ($logo_path && file_exists('../' . $logo_path)) {
                    unlink('../' . $logo_path);
                }
                $logo_path = $new_logo_path;
            } elseif ($new_logo_path === false) {
                 send_json_response(false, 'Failed to upload new logo.');
            }

            $new_bg_image_path = handle_file_upload('bgImageFile', $partner_id, 'bg');
             if ($new_bg_image_path) {
                if ($bg_image_path && file_exists('../' . $bg_image_path)) {
                    unlink('../' . $bg_image_path);
                }
                $bg_image_path = $new_bg_image_path;
            } elseif ($new_bg_image_path === false) {
                send_json_response(false, 'Failed to upload new background image.');
            }

            $sql = "UPDATE partners SET name = :name, website_link = :website_link, logo_path = :logo_path, background_image_path = :bg_image_path WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $_POST['name'] ?? '',
                ':website_link' => $_POST['website_link'] ?? '',
                ':logo_path' => $logo_path,
                ':bg_image_path' => $bg_image_path,
                ':id' => $partner_id
            ]);

            send_json_response(true, 'Partner updated successfully.');

        } catch (PDOException $e) {
            send_json_response(false, 'Database error: ' . $e->getMessage());
        }
        break;

    case 'delete':
        try {
            $partner_id = $_POST['id'] ?? null;
            if (!$partner_id) {
                send_json_response(false, 'Partner ID is missing.');
            }

            // Get file paths before deleting the record
            $stmt = $pdo->prepare("SELECT logo_path, background_image_path FROM partners WHERE id = :id");
            $stmt->execute([':id' => $partner_id]);
            $paths = $stmt->fetch(PDO::FETCH_ASSOC);

            // Delete record from DB
            $delete_stmt = $pdo->prepare("DELETE FROM partners WHERE id = :id");
            $delete_stmt->execute([':id' => $partner_id]);

            // If deletion was successful, delete files from server
            if ($delete_stmt->rowCount() > 0) {
                if ($paths['logo_path'] && file_exists('../' . $paths['logo_path'])) {
                    unlink('../' . $paths['logo_path']);
                }
                if ($paths['background_image_path'] && file_exists('../' . $paths['background_image_path'])) {
                    unlink('../' . $paths['background_image_path']);
                }
            }

            send_json_response(true, 'Partner deleted successfully.');

        } catch (PDOException $e) {
            send_json_response(false, 'Database error: ' . $e->getMessage());
        }
        break;

    default:
        send_json_response(false, 'Invalid action specified.');
        break;
}
?>
