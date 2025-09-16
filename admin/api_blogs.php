<?php
// api_blogs.php
header('Content-Type: application/json');
require_once '../config.php'; // Provides $pdo

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

try {
    // Check for action
    if (!isset($_REQUEST['action'])) {
        throw new Exception('Action not specified.');
    }

    $action = $_REQUEST['action'];

    if ($action == 'fetch') {
        if (!isset($_GET['page_key'])) {
            throw new Exception('Page key not provided.');
        }
        $page_key = $_GET['page_key'];

        // Fetch main page data
        $stmt = $pdo->prepare("SELECT * FROM blog_pages WHERE page_key = ?");
        $stmt->execute([$page_key]);
        $page = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$page) {
            throw new Exception('Blog page not found.');
        }

        // Fetch sections for this page
        $stmt = $pdo->prepare("SELECT * FROM blog_page_sections WHERE page_id = ? ORDER BY sort_order ASC");
        $stmt->execute([$page['id']]);
        $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $page['sections'] = $sections;

        $response = ['success' => true, 'data' => $page];
    } 
    elseif ($action == 'update') {
        // Begin transaction
        $pdo->beginTransaction();

        $page_key = $_POST['page_key'] ?? null;
        if (!$page_key) {
            throw new Exception("Page key is missing.");
        }

        // 1. Get page ID from page key
        $stmt = $pdo->prepare("SELECT id FROM blog_pages WHERE page_key = ?");
        $stmt->execute([$page_key]);
        $page_id = $stmt->fetchColumn();

        if (!$page_id) {
            throw new Exception("Invalid page key provided.");
        }

        // 2. Handle main image upload
        $main_image_path = null;
        if (isset($_FILES['main_image_file']) && $_FILES['main_image_file']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = '../blog/img/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid() . '-' . basename($_FILES['main_image_file']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['main_image_file']['tmp_name'], $targetPath)) {
                // Store relative path for web access
                $main_image_path = 'blog/img/' . $fileName;
            } else {
                throw new Exception("Failed to move main uploaded file.");
            }
        }

        // 3. Update the blog_pages table
        $sql = "UPDATE blog_pages SET title = ?, author = ?, main_content = ?";
        $params = [
            $_POST['title'] ?? '',
            $_POST['author'] ?? '',
            $_POST['main_content'] ?? ''
        ];
        if ($main_image_path) {
            $sql .= ", main_image_path = ?";
            $params[] = $main_image_path;
        }
        $sql .= " WHERE id = ?";
        $params[] = $page_id;
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        // 4. Update sections
        if (isset($_POST['sections'])) {
            $sections = json_decode($_POST['sections'], true);
            foreach ($sections as $index => $section) {
                $section_id = $section['id'];
                $section_image_path = null;

                // Handle section image upload
                $file_key = 'section_image_file_' . $section_id;
                if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] == UPLOAD_ERR_OK) {
                    $uploadDir = '../blog/img/';
                     if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $fileName = uniqid() . '-' . basename($_FILES[$file_key]['name']);
                    $targetPath = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $targetPath)) {
                        $section_image_path = 'blog/img/' . $fileName;
                    } else {
                        throw new Exception("Failed to move section file for section ID " . $section_id);
                    }
                }
                
                // Update the blog_page_sections table
                $sql_sec = "UPDATE blog_page_sections SET title = ?, content = ?, sort_order = ?";
                $params_sec = [
                    $section['title'] ?? '',
                    $section['content'] ?? '',
                    $index
                ];

                if ($section_image_path) {
                    $sql_sec .= ", image_path = ?";
                    $params_sec[] = $section_image_path;
                }
                $sql_sec .= " WHERE id = ?";
                $params_sec[] = $section_id;

                $stmt_sec = $pdo->prepare($sql_sec);
                $stmt_sec->execute($params_sec);
            }
        }

        // Commit transaction
        $pdo->commit();
        $response = ['success' => true, 'message' => 'Blog page updated successfully.'];

    } else {
        throw new Exception('Invalid action specified.');
    }
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $response['message'] = 'A critical error occurred: ' . $e->getMessage();
}

echo json_encode($response);
?>

