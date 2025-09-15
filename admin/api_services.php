<?php
// api_services.php
// This API handles fetching and updating content for service pages like Caregiver and Family Permit.

session_start();
header('Content-Type: application/json');
require_once '../config.php'; // Database connection

// Security check: ensure user is an admin
if (!isset($_SESSION['loggedin']) || strpos($_SESSION['role'], 'Admin') === false) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'fetch':
        fetchServiceData($pdo);
        break;
    case 'update':
        updateServiceData($pdo);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action specified.']);
}

function fetchServiceData($pdo) {
    if (!isset($_GET['service_key'])) {
        echo json_encode(['success' => false, 'message' => 'Service key not provided.']);
        return;
    }
    $serviceKey = $_GET['service_key'];

    try {
        // Fetch main service details
        $stmt_service = $pdo->prepare("SELECT * FROM services WHERE service_key = ?");
        $stmt_service->execute([$serviceKey]);
        $service = $stmt_service->fetch(PDO::FETCH_ASSOC);

        if (!$service) {
            echo json_encode(['success' => false, 'message' => 'Service not found.']);
            return;
        }

        // Fetch tab details for the service
        $stmt_tabs = $pdo->prepare("SELECT * FROM service_tabs WHERE service_id = ? ORDER BY display_order ASC");
        $stmt_tabs->execute([$service['id']]);
        $tabs = $stmt_tabs->fetchAll(PDO::FETCH_ASSOC);

        $service['tabs'] = $tabs;

        echo json_encode(['success' => true, 'data' => $service]);

    } catch (PDOException $e) {
        // In a real application, log this error instead of echoing it.
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

function updateServiceData($pdo) {
    // --- Collect and validate POST data ---
    $serviceId = $_POST['service_id'] ?? null;
    $heroTitle = $_POST['hero_title'] ?? '';
    $heroDescription = $_POST['hero_description'] ?? '';
    $tabsData = isset($_POST['tabs']) ? json_decode($_POST['tabs'], true) : [];
    
    if (!$serviceId || !is_array($tabsData)) {
        echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
        return;
    }

    try {
        $pdo->beginTransaction();

        // --- Handle Hero Image Upload ---
        $heroImagePath = $_POST['existing_hero_image_path'];
        if (isset($_FILES['hero_image_file']) && $_FILES['hero_image_file']['error'] == 0) {
            $uploadDir = '../img/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . '_' . basename($_FILES['hero_image_file']['name']);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['hero_image_file']['tmp_name'], $targetPath)) {
                $heroImagePath = 'img/' . $fileName;
            } else {
                throw new Exception('Failed to upload hero image.');
            }
        }
        
        // --- Update Main Service Table ---
        $stmt_service = $pdo->prepare(
            "UPDATE services SET hero_title = ?, hero_description = ?, hero_image_path = ? WHERE id = ?"
        );
        $stmt_service->execute([$heroTitle, $heroDescription, $heroImagePath, $serviceId]);

        // --- Update Service Tabs Table ---
        $stmt_tab_update = $pdo->prepare(
            "UPDATE service_tabs SET content = ?, image_path = ? WHERE id = ?"
        );
        
        foreach ($tabsData as $tab) {
            $tabId = $tab['id'];
            $tabContent = $tab['content'];
            $existingImagePath = $tab['existing_image_path'];
            
            // Check for a new file for this specific tab
            $fileKey = 'tab_image_file_' . $tabId;
            if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0) {
                $uploadDir = '../img/';
                 if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . '_' . basename($_FILES[$fileKey]['name']);
                $targetPath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $targetPath)) {
                    $existingImagePath = 'img/' . $fileName;
                } else {
                    throw new Exception("Failed to upload image for tab ID {$tabId}.");
                }
            }
            
            $stmt_tab_update->execute([$tabContent, $existingImagePath, $tabId]);
        }
        
        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Service content updated successfully.']);

    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>

