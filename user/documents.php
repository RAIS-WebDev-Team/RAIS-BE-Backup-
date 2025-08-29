<?php
// documents.php - Page for users to manage their documents

// Start the session to access logged-in user's data.
session_start();

// Include the database configuration file.
include_once '../config.php';

// Check if the user is logged in. If not, redirect them to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../login.php");
    exit;
}

$userId = $_SESSION['id'];

// --- SERVER-SIDE ACTION HANDLER (UPLOAD/DELETE) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $response = [];

    // --- HANDLE FILE UPLOAD ---
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        // Define the upload directory. Ensure this directory exists and is writable.
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Check for upload errors.
        if ($file['error'] === UPLOAD_ERR_OK) {
            $originalFileName = basename($file['name']);
            $fileType = $file['type']; // We still need this to send back to the client
            // Create a unique filename to prevent overwriting existing files.
            $uniqueFileName = uniqid() . '-' . preg_replace("/[^a-zA-Z0-9\._-]/", "", $originalFileName);
            $filePath = $uploadDir . $uniqueFileName;

            // Move the file to the uploads directory.
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                // Save file metadata to the database, without the file_type column.
                $stmt = $conn->prepare("INSERT INTO user_documents (user_id, file_name, file_path, status) VALUES (?, ?, ?, 'pending')");
                $stmt->bind_param("iss", $userId, $originalFileName, $filePath);
                if ($stmt->execute()) {
                    $lastId = $stmt->insert_id;
                    // Send fileType in the response so the JS can render the icon immediately.
                    $response = ['status' => 'success', 'fileId' => $lastId, 'fileName' => $originalFileName, 'fileType' => $fileType, 'filePath' => $filePath];
                } else {
                    $response = ['status' => 'error', 'message' => 'Database error: ' . $stmt->error];
                    unlink($filePath); // Clean up the uploaded file if DB insert fails.
                }
                $stmt->close();
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to move uploaded file. Check directory permissions.'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'File upload error code: ' . $file['error']];
        }
    }
    // --- HANDLE FILE DELETE ---
    elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $fileIds = isset($_POST['ids']) ? (is_array($_POST['ids']) ? $_POST['ids'] : [$_POST['ids']]) : [];
        
        if (!empty($fileIds)) {
            // Prepare placeholders for the SQL query to handle multiple IDs safely.
            $placeholders = implode(',', array_fill(0, count($fileIds), '?'));
            $types = str_repeat('i', count($fileIds));

            // First, select the files to verify ownership and get their paths for deletion.
            $sql = "SELECT id, file_path FROM user_documents WHERE user_id = ? AND id IN ($placeholders)";
            $stmt = $conn->prepare($sql);
            $params = array_merge([$userId], $fileIds);
            $stmt->bind_param('i' . $types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $filesToDelete = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            if (!empty($filesToDelete)) {
                $idsToDelete = array_column($filesToDelete, 'id');
                $placeholdersToDelete = implode(',', array_fill(0, count($idsToDelete), '?'));
                $typesToDelete = str_repeat('i', count($idsToDelete));

                // Delete records from the database.
                $stmt_delete = $conn->prepare("DELETE FROM user_documents WHERE user_id = ? AND id IN ($placeholdersToDelete)");
                $delete_params = array_merge([$userId], $idsToDelete);
                $stmt_delete->bind_param('i' . $typesToDelete, ...$delete_params);

                if ($stmt_delete->execute()) {
                    // After successful DB deletion, delete files from the server.
                    foreach ($filesToDelete as $file) {
                        if (file_exists($file['file_path'])) {
                            unlink($file['file_path']);
                        }
                    }
                    $response = ['status' => 'success', 'message' => "File(s) deleted successfully."];
                } else {
                    $response = ['status' => 'error', 'message' => "Database deletion failed: " . $stmt_delete->error];
                }
                $stmt_delete->close();
            } else {
                $response = ['status' => 'error', 'message' => "No matching files found or permission denied."];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'No file IDs provided.'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid request.'];
    }

    // Return the JSON response and stop script execution.
    echo json_encode($response);
    $conn->close();
    exit;
}

// --- PAGE LOAD LOGIC (GET REQUEST) ---

// Fetch user's first name and dark mode setting.
$stmt = $conn->prepare("SELECT firstName, dark_mode FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$darkModeEnabled = $user ? (bool)$user['dark_mode'] : false;
$stmt->close();

// Fetch all documents for the logged-in user and categorize them.
$pendingFiles = [];
$approvedFiles = [];
$cancelledFiles = [];

// Select documents without the 'file_type' column.
$stmt = $conn->prepare("SELECT id, file_name, file_path, status FROM user_documents WHERE user_id = ? ORDER BY upload_date DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    // Infer file_type from the filename extension for rendering purposes.
    $extension = strtolower(pathinfo($row['file_name'], PATHINFO_EXTENSION));
    $inferred_file_type = 'application/octet-stream'; // Default type
    $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
    $word_extensions = ['doc', 'docx'];

    if (in_array($extension, $image_extensions)) {
        $inferred_file_type = 'image/' . $extension;
    } elseif ($extension === 'pdf') {
        $inferred_file_type = 'application/pdf';
    } elseif (in_array($extension, $word_extensions)) {
        $inferred_file_type = 'application/msword';
    }
    // Add the inferred type to the row array so the rest of the code can use it.
    $row['file_type'] = $inferred_file_type;

    switch ($row['status']) {
        case 'approved':
            $approvedFiles[] = $row;
            break;
        case 'cancelled':
            $cancelledFiles[] = $row;
            break;
        case 'pending':
        default:
            $pendingFiles[] = $row;
            break;
    }
}
$stmt->close();
$conn->close();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAIS Documents</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../img/logoulit.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        :root {
            --rais-primary-green: #004d40;
            --rais-dark-green: #00332c;
            --rais-text-dark: #333333;
            --rais-text-light: #525252;
            --rais-card-bg: #FFFFFF;
            --rais-light-gray: #E8E8E8;
            --rais-bg-light: #F7F7F7;
            --rais-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            --rais-button-maroon: #811F1D;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--rais-light-gray);
            color: var(--rais-text-dark);
            overflow: hidden; /* Prevent body scroll */
        }

        .main-wrapper {
            display: flex;
            height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: var(--rais-primary-green);
            width: 70px;
            flex-shrink: 0;
            color: white;
            padding: 30px 0;
            box-shadow: var(--rais-shadow);
            transition: width 0.3s ease-in-out;
            overflow: hidden;
            position: fixed;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 1031;
        }

        .sidebar:hover {
            width: 280px;
        }

        .sidebar .logo {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 1px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .sidebar:hover .logo {
            opacity: 1;
        }

        .sidebar .nav {
            flex-grow: 1;
        }

        .sidebar .nav-link {
            color: white;
            font-weight: 500;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            white-space: nowrap;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: var(--rais-dark-green);
            color: #fff;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
            min-width: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.1);
        }

        .sidebar .nav-link span {
            opacity: 0;
            transition: opacity 0.1s ease-in-out 0.2s;
        }

        .sidebar:hover .nav-link span {
            opacity: 1;
        }

        .sidebar .footer-text {
            font-size: 0.8rem;
            color: #bbb;
            text-align: center;
            padding: 15px 0;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            margin-top: auto;
        }

        .sidebar:hover .footer-text {
            opacity: 1;
        }
        
        .content-area {
            flex-grow: 1;
            height: 100vh;
            overflow-y: auto;
            margin-left: 70px;
        }

        /* Header Styles */
        .header {
            background-color: var(--rais-bg-light);
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            box-shadow: var(--rais-shadow);
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        
        .header-brand {
            gap: 10px;
        }
        
        .header-logo-img {
            height: 100px;
            width: auto;
            object-fit: contain;
        }
        
        .header-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--rais-text-dark);
            white-space: nowrap;
        }
        
        .user-status {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header .user-status .btn-link {
            color: var(--rais-text-light);
            transition: color 0.3s ease;
        }

        .header .user-status .btn-link:hover {
            color: var(--rais-button-maroon);
        }

        .user-status .badge {
            background-color: var(--rais-button-maroon);
            font-size: 0.8rem;
            font-weight: 500;
            padding: 5px 15px;
            border-radius: 20px;
        }

        .user-status .btn {
            color: var(--rais-text-light);
            font-size: 1.5rem;
            padding: 0;
        }
        
        .power-btn i {
            color: #dc3545;
        }

        .power-btn:hover i {
            color: #a71d2a;
        }

        /* Main Content Styles */
        .main-content {
            flex-grow: 1;
            padding: 30px;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .main-content h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .document-section {
            background-color: var(--rais-card-bg);
            border-radius: 12px;
            box-shadow: var(--rais-shadow);
            padding: 20px;
            margin-bottom: 2rem;
        }

        .document-header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 1rem;
            gap: 20px;
        }

        .document-header .btn-icon {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--rais-text-light);
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .document-header .btn-icon:hover {
            color: var(--rais-primary-green);
            transform: translateY(-2px);
        }
        
        .header-icon-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
        }

        .icon-label {
            font-size: 0.75rem;
            color: var(--rais-text-light);
            margin-top: 4px;
        }

        .file-preview-container {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .file-preview-item {
            text-align: center;
            width: 100px;
            cursor: pointer;
            padding: 5px;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        .file-preview-item:hover {
            background-color: var(--rais-bg-light);
            transform: translateY(-3px);
            box-shadow: var(--rais-shadow);
        }

        .file-preview-item.selected {
            background-color: var(--rais-light-gray);
            border: 2px solid var(--rais-primary-green);
        }

        .file-preview-item i {
            font-size: 3rem;
            color: var(--rais-primary-green);
            transition: color 0.2s ease-in-out;
        }

        .file-preview-item:hover i {
            color: var(--rais-dark-green);
        }

        .file-preview-item .file-name {
            font-size: 0.8rem;
            color: var(--rais-text-dark);
            margin-top: 0.5rem;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .status-tabs .nav-link {
            color: var(--rais-text-light);
            border: none;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .status-tabs .nav-link.active {
            color: var(--rais-primary-green);
            border-bottom-color: var(--rais-primary-green);
            font-weight: 600;
        }

        .status-tabs .nav-link:hover {
            color: var(--rais-primary-green);
        }

        #previewModal .modal-body img {
            max-width: 100%;
            height: auto;
        }

        #previewModal .modal-body .icon-preview {
            font-size: 6rem;
            text-align: center;
            display: block;
            color: var(--rais-primary-green);
        }

        /* Floating Button */
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: var(--rais-button-maroon);
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            transition: background-color 0.2s, transform 0.2s;
            z-index: 100;
        }

        .floating-btn:hover {
            background-color: var(--rais-dark-green);
            transform: scale(1.1) rotate(90deg);
        }

        /* Collapsible Chatbox */
        .chat-container {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 350px;
            max-height: 500px;
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--rais-shadow);
            display: flex;
            flex-direction: column;
            z-index: 99;
            transform: translateY(100%);
            opacity: 0;
            visibility: hidden;
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

        .chat-container.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .chat-header {
            background-color: var(--rais-primary-green);
            color: white;
            padding: 1rem;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            cursor: pointer;
        }

        .chat-body {
            padding: 1rem;
            flex-grow: 1;
            overflow-y: auto;
            background-color: var(--rais-bg-light);
            display: flex;
            flex-direction: column-reverse;
            height: 350px;
        }

        .chat-footer {
            padding: 1rem;
            border-top: 1px solid var(--rais-light-gray);
        }

        .chat-footer .input-group {
            border-radius: 20px;
        }

        .chat-footer .form-control {
            border-radius: 20px 0 0 20px;
        }

        .chat-footer .btn {
            transition: all 0.3s ease;
        }

        .chat-footer .btn:hover {
            background-color: var(--rais-button-maroon);
        }

        .chat-footer .btn:hover i {
            color: white !important;
        }

        .chat-toggle-btn {
            position: fixed;
            bottom: 30px;
            right: 100px;
            background-color: var(--rais-button-maroon);
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 100;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .chat-toggle-btn:hover {
            background-color: var(--rais-dark-green);
            transform: scale(1.1);
        }
        
        #full-screen-chat {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: var(--rais-bg-light);
            z-index: 2000;
            display: none;
            flex-direction: column;
        }

        .chat-header-fullscreen {
            display: flex;
            align-items: center;
            padding: 1rem;
            background-color: var(--rais-primary-green);
            color: white;
            flex-shrink: 0;
        }

        .back-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            margin-right: 1rem;
        }

        .chat-title-fullscreen {
            font-weight: 600;
            font-size: 1.2rem;
        }

        .chat-body-fullscreen {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column-reverse;
        }

        .chat-footer-fullscreen {
            padding: 1rem;
            border-top: 1px solid var(--rais-light-gray);
            background-color: white;
            flex-shrink: 0;
        }
        
        .chat-footer .btn i, .chat-footer-fullscreen .btn i {
            color: var(--rais-text-dark);
        }

        /* Dark Mode Styles */
        .dark-mode-logo {
            display: none;
        }
        .dark-mode .light-mode-logo {
            display: none;
        }
        .dark-mode .dark-mode-logo {
            display: block;
        }
        body.dark-mode {
            background-color: #121212;
            color: #EAEAEA;
        }
        .dark-mode .sidebar {
            background-color: #1a1a1a;
            border-right: 1px solid #2c2c2c;
        }
        .dark-mode .header,
        .dark-mode .document-section,
        .dark-mode .modal-content,
        .dark-mode .chat-container,
        .dark-mode #full-screen-chat,
        .dark-mode .chat-footer-fullscreen {
            background-color: #1e1e1e;
            color: #EAEAEA;
            border-color: #2c2c2c;
        }
        .dark-mode .header {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .dark-mode .header-title,
        .dark-mode h1, .dark-mode h5,
        .dark-mode .user-status .me-3,
        .dark-mode .chat-title-fullscreen,
        .dark-mode .file-name {
            color: #EAEAEA !important;
        }
        .dark-mode .status-tabs .nav-link {
            color: #B0B0B0;
        }
        .dark-mode .status-tabs .nav-link.active,
        .dark-mode .status-tabs .nav-link:hover {
            color: var(--rais-primary-green);
        }
        .dark-mode .file-preview-item:hover {
            background-color: #2c2c2c;
        }
        .dark-mode .file-preview-item.selected {
            background-color: #2c2c2c;
        }
        .dark-mode .modal-header, .dark-mode .modal-footer {
            border-bottom-color: #2c2c2c;
            border-top-color: #2c2c2c;
        }
        .dark-mode .file-preview-item i {
            color: #EAEAEA;
        }
        .dark-mode .document-header .btn-icon {
            color: #EAEAEA;
        }
        .dark-mode .icon-label {
            color: #B0B0B0;
        }
        .dark-mode .chat-body {
            background-color: #121212;
        }
        .dark-mode .chat-body .text-muted, .dark-mode .chat-body-fullscreen .text-muted {
            color: #EAEAEA !important;
        }
        .dark-mode .form-control {
            background-color: #2a2a2a;
            color: #EAEAEA;
            border-color: #3c3c3c;
        }
        .dark-mode .form-control::placeholder {
            color: #888;
        }
        .dark-mode .chat-footer .btn i, .dark-mode .chat-footer-fullscreen .btn i {
            color: #EAEAEA;
        }
        .dark-mode .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            body {
                padding-top: 60px;
                padding-bottom: 50px;
                overflow: auto;
            }

            .main-wrapper {
                flex-direction: column;
                height: auto;
            }
            
            .content-area {
                height: auto;
                overflow-y: visible;
                margin-left: 0;
            }

            .header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1030;
            }

            .header .logo-img {
                height: 120px;
                width: 120px;
            }
            
            .header-title {
                display: none;
            }

            .main-content {
                padding-top: 15px;
            }

            /* Transform sidebar into a bottom navigation bar */
            .sidebar {
                width: 100%;
                height: 50px;
                position: fixed;
                top: auto;
                bottom: 0;
                left: 0;
                z-index: 1029;
                flex-direction: row;
                align-items: center;
                padding: 0;
                transition: none;
                overflow-x: auto;
                overflow-y: hidden;
            }

            .sidebar:hover {
                width: 100%;
            }

            .sidebar .logo,
            .sidebar .footer-text,
            .profile-section {
                display: none;
            }

            .sidebar .nav {
                display: flex;
                flex-direction: row;
                align-items: center;
                flex-grow: 1;
                height: 100%;
            }

            .sidebar .nav-link {
                flex-direction: row;
                justify-content: center;
                align-items: center;
                padding: 0 20px;
                gap: 0;
                height: 100%;
            }

            .sidebar .nav-link:hover {
                background-color: var(--rais-dark-green);
            }

            .sidebar .nav-link i {
                font-size: 1.5rem;
                margin-bottom: 0;
            }

            .sidebar .nav-link span,
            .sidebar:hover .nav-link span {
                display: none;
            }

            .floating-btn {
                bottom: 80px;
                right: 15px;
            }

            .chat-toggle-btn {
                bottom: 80px;
                right: 85px;
            }
            
            .chat-container {
                display: none !important;
            }
        }
    </style>
</head>

<body class="<?php echo $darkModeEnabled ? 'dark-mode' : ''; ?>">
    <div class="main-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar d-flex flex-column">
            <div class="logo">RAIS</div>
            <nav class="nav flex-column">
                <a class="nav-link" href="dashboard.php"><i class="bi bi-house-door-fill"></i><span>Dashboard</span></a>
                <a class="nav-link" href="book-consultation.php"><i class="bi bi-calendar-check"></i><span>Book
                        Consultation</span></a>
                <a class="nav-link" href="statement-of-account.php"><i class="bi bi-receipt"></i><span>Statement of
                        Account</span></a>
                <a class="nav-link active" href="documents.php"><i
                        class="bi bi-file-earmark-text"></i><span>Documents</span></a>
                <a class="nav-link" href="forms.php"><i class="bi bi-journal-text"></i><span>Forms</span></a>
                <a class="nav-link" href="notifications.php"><i class="bi bi-bell"></i><span>Notifications</span></a>
                <a class="nav-link" href="settings.php"><i class="bi bi-gear"></i><span>Settings</span></a>
                <a class="nav-link" href="profile.php"><i class="bi bi-person-circle"></i><span>Profile</span></a>
            </nav>

            <div class="mt-auto footer-text">
                &copy; <?php echo date("Y"); ?> RAIS
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="content-area">
            <!-- Header -->
            <div class="header">
                <div class="header-brand d-flex align-items-center">
                    <img src="../img/logo.png" alt="RAIS Logo" class="header-logo-img light-mode-logo">
                    <img src="../img/logo1.png" alt="RAIS Logo Dark" class="header-logo-img dark-mode-logo" onerror="this.style.display='none'">
                    <span class="header-title">Roman & Associates Immigration Services</span>
                </div>
                <div class="user-status d-flex align-items-center gap-2">
                    <div id="headerDate" class="me-3" style="font-weight: 500;"></div>
                    <a href="#" class="btn btn-link power-btn" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="bi bi-power"></i></a>
                    <span class="badge"><?php echo htmlspecialchars($user['firstName']); ?></span>
                </div>
            </div>

            <!-- Main Content -->
            <main class="main-content">
                <h1>PLEASE SUBMIT YOUR DOCUMENTS</h1>

                <div class="document-section">
                    <div class="document-header">
                        <div class="header-icon-container" onclick="document.getElementById('fileUpload').click()">
                            <button class="btn-icon"><i class="bi bi-file-earmark-arrow-up"></i></button>
                            <div class="icon-label">Upload File</div>
                        </div>
                        <input type="file" id="fileUpload" style="display: none;" multiple>
                        
                        <div class="header-icon-container" id="deleteBtnContainer">
                            <button class="btn-icon"><i class="bi bi-trash"></i></button>
                            <div class="icon-label">Delete</div>
                        </div>
                    </div>
                    <hr>
                    <ul class="nav nav-tabs status-tabs" id="statusTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab"
                                data-bs-target="#pending" type="button" role="tab" aria-controls="pending"
                                aria-selected="true">Pending</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved"
                                type="button" role="tab" aria-controls="approved"
                                aria-selected="false">Approved</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled"
                                type="button" role="tab" aria-controls="cancelled"
                                aria-selected="false">Cancelled</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="pending" role="tabpanel"
                            aria-labelledby="pending-tab">
                            <div id="pendingFiles" class="file-preview-container">
                                <?php if (empty($pendingFiles)): ?>
                                    <p class="text-muted w-100 text-center">No pending documents. Upload files using the icons above.</p>
                                <?php else: ?>
                                    <?php foreach ($pendingFiles as $file): ?>
                                        <?php
                                            $iconClass = 'bi-file-earmark-text'; // Default icon
                                            if (strpos($file['file_type'], 'image/') === 0) $iconClass = 'bi-file-earmark-image';
                                            if (strpos($file['file_type'], 'pdf') !== false) $iconClass = 'bi-file-earmark-pdf';
                                            if (strpos($file['file_type'], 'word') !== false) $iconClass = 'bi-file-earmark-word';
                                        ?>
                                        <div class="file-preview-item" data-file-id="<?= htmlspecialchars($file['id']) ?>" data-file-path="<?= htmlspecialchars($file['file_path']) ?>" data-file-name="<?= htmlspecialchars($file['file_name']) ?>" data-file-type="<?= htmlspecialchars($file['file_type']) ?>">
                                            <i class="bi <?= $iconClass ?>"></i>
                                            <div class="file-name" title="<?= htmlspecialchars($file['file_name']) ?>"><?= htmlspecialchars($file['file_name']) ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                             <div id="approvedFiles" class="file-preview-container">
                                <?php if (empty($approvedFiles)): ?>
                                    <p class="text-muted w-100 text-center">No approved documents.</p>
                                <?php else: ?>
                                    <?php foreach ($approvedFiles as $file): ?>
                                        <?php
                                            $iconClass = 'bi-file-earmark-text';
                                            if (strpos($file['file_type'], 'image/') === 0) $iconClass = 'bi-file-earmark-image';
                                            if (strpos($file['file_type'], 'pdf') !== false) $iconClass = 'bi-file-earmark-pdf';
                                            if (strpos($file['file_type'], 'word') !== false) $iconClass = 'bi-file-earmark-word';
                                        ?>
                                        <div class="file-preview-item" data-file-id="<?= htmlspecialchars($file['id']) ?>" data-file-path="<?= htmlspecialchars($file['file_path']) ?>" data-file-name="<?= htmlspecialchars($file['file_name']) ?>" data-file-type="<?= htmlspecialchars($file['file_type']) ?>">
                                            <i class="bi <?= $iconClass ?>"></i>
                                            <div class="file-name" title="<?= htmlspecialchars($file['file_name']) ?>"><?= htmlspecialchars($file['file_name']) ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                             <div id="cancelledFiles" class="file-preview-container">
                                <?php if (empty($cancelledFiles)): ?>
                                    <p class="text-muted w-100 text-center">No cancelled documents.</p>
                                <?php else: ?>
                                    <?php foreach ($cancelledFiles as $file): ?>
                                        <?php
                                            $iconClass = 'bi-file-earmark-text';
                                            if (strpos($file['file_type'], 'image/') === 0) $iconClass = 'bi-file-earmark-image';
                                            if (strpos($file['file_type'], 'pdf') !== false) $iconClass = 'bi-file-earmark-pdf';
                                            if (strpos($file['file_type'], 'word') !== false) $iconClass = 'bi-file-earmark-word';
                                        ?>
                                        <div class="file-preview-item" data-file-id="<?= htmlspecialchars($file['id']) ?>" data-file-path="<?= htmlspecialchars($file['file_path']) ?>" data-file-name="<?= htmlspecialchars($file['file_name']) ?>" data-file-type="<?= htmlspecialchars($file['file_type']) ?>">
                                            <i class="bi <?= $iconClass ?>"></i>
                                            <div class="file-name" title="<?= htmlspecialchars($file['file_name']) ?>"><?= htmlspecialchars($file['file_name']) ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Preview content will be injected here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="modalRemoveBtn">Remove</button>
                    <a href="#" class="btn btn-primary" id="modalDownloadBtn" download>Download</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete the selected file(s)? This action cannot be undone.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to log out?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Floating Action Button -->
    <a href="book-flight.php" class="floating-btn text-decoration-none">
        <i class="bi bi-plus-lg"></i>
    </a>

    <!-- Collapsible Chatbox -->
    <div class="chat-container" id="chatContainer">
        <div class="chat-header d-flex justify-content-between align-items-center" onclick="toggleChat()">
            <h5 class="chat-modal-title mb-0"><i class="bi bi-chat-dots-fill me-2"></i>Live Chat</h5>
            <i class="bi bi-x-lg text-white"></i>
        </div>
        <div class="chat-body">
            <div class="text-center text-muted">Start a new conversation.</div>
        </div>
        <div class="chat-footer">
            <div class="input-group">
                <input type="text" class="form-control message-input" placeholder="Type a message..."
                    aria-label="Message input">
                <button class="btn btn-outline-secondary" type="button" id="send-button-popup">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Full Screen Chat for Mobile -->
    <div id="full-screen-chat">
        <div class="chat-header-fullscreen">
            <button class="back-btn" id="backToDashboardBtn"><i class="bi bi-arrow-left"></i></button>
            <span class="chat-title-fullscreen"><i class="bi bi-chat-dots-fill me-2"></i>Live Chat</span>
        </div>
        <div class="chat-body-fullscreen">
            <div class="text-center text-muted">RAIS Support, how may I help you?</div>
        </div>
        <div class="chat-footer-fullscreen">
            <div class="input-group">
                <input type="text" class="form-control message-input" placeholder="Type a message..."
                    aria-label="Message input">
                <button class="btn btn-outline-secondary" type="button" id="send-button-fullscreen">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Floating Chat Toggle Button -->
    <button class="chat-toggle-btn" onclick="toggleChat()">
        <i class="bi bi-chat-dots"></i>
    </button>


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Update the date dynamically in the header
            document.getElementById('headerDate').textContent = new Date().toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
            
            // --- CHAT TOGGLE LOGIC ---
            const mainWrapper = document.querySelector('.main-wrapper');
            const floatingBtn = document.querySelector('.floating-btn');
            const chatToggleBtn = document.querySelector('.chat-toggle-btn');
            const popupChatContainer = document.getElementById('chatContainer');
            const fullScreenChat = document.getElementById('full-screen-chat');

            window.toggleChat = function() {
                if (window.innerWidth <= 992) {
                    const isChatVisible = fullScreenChat.style.display === 'flex';
                    if (isChatVisible) {
                        fullScreenChat.style.display = 'none';
                        mainWrapper.style.display = 'flex';
                        floatingBtn.style.display = 'flex';
                        chatToggleBtn.style.display = 'flex';
                    } else {
                        fullScreenChat.style.display = 'flex';
                        mainWrapper.style.display = 'none';
                        floatingBtn.style.display = 'none';
                        chatToggleBtn.style.display = 'none';
                    }
                } else {
                    popupChatContainer.classList.toggle('show');
                }
            }
            
            document.getElementById('backToDashboardBtn').addEventListener('click', window.toggleChat);

            // --- FILE MANAGEMENT LOGIC ---
            const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
            const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            
            let activeFileInModal = null;
            let deleteActionCallback = null;

            // Helper function to create a new file preview element in the DOM
            function createFilePreviewElement(fileId, fileName, fileType, filePath) {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-preview-item';
                fileItem.dataset.fileId = fileId;
                fileItem.dataset.fileName = fileName;
                fileItem.dataset.fileType = fileType;
                fileItem.dataset.filePath = filePath;

                let iconClass = 'bi-file-earmark-text';
                if (fileType.startsWith('image/')) iconClass = 'bi-file-earmark-image';
                if (fileType.includes('pdf')) iconClass = 'bi-file-earmark-pdf';
                if (fileType.includes('word')) iconClass = 'bi-file-earmark-word';

                fileItem.innerHTML = `
                    <i class="bi ${iconClass}"></i>
                    <div class="file-name" title="${fileName}">${fileName}</div>
                `;
                addFileItemEventListeners(fileItem);
                return fileItem;
            }

            // Handles file uploads by sending them to the server
            function handleFileUpload(event) {
                const files = event.target.files;
                const container = document.getElementById('pendingFiles');
                const noFilesMessage = container.querySelector('p');

                if (noFilesMessage) {
                    noFilesMessage.remove();
                }

                for (const file of files) {
                    const formData = new FormData();
                    formData.append('file', file);

                    fetch('documents.php', { method: 'POST', body: formData })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                const newFileElement = createFilePreviewElement(data.fileId, data.fileName, data.fileType, data.filePath);
                                container.prepend(newFileElement);
                            } else {
                                console.error('Upload failed:', data.message);
                                // Consider adding a user-friendly error message to the UI
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
                event.target.value = ''; // Reset input
            }

            // Triggers the confirmation modal for deleting selected files
            function triggerDeleteConfirmation() {
                const activeTabPane = document.querySelector('.tab-content .tab-pane.active#pending');
                if (!activeTabPane) {
                    // Deletion is only allowed from the pending tab.
                    // You might want to show a message here.
                    return;
                }
                const container = activeTabPane.querySelector('.file-preview-container');
                const selectedItems = container.querySelectorAll('.file-preview-item.selected');
                
                if (selectedItems.length === 0) return;

                deleteActionCallback = () => performDelete(selectedItems);
                confirmDeleteModal.show();
            }

            // Performs the actual deletion after confirmation
            function performDelete(itemsToDelete) {
                const fileIds = Array.from(itemsToDelete).map(item => item.dataset.fileId);
                const formData = new FormData();
                formData.append('action', 'delete');
                fileIds.forEach(id => formData.append('ids[]', id));

                fetch('documents.php', { method: 'POST', body: formData })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            itemsToDelete.forEach(item => item.remove());
                        } else {
                            console.error('Deletion failed:', data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Shows the file preview in a modal
            function showPreview(fileElement) {
                activeFileInModal = fileElement;
                const { fileId, fileName, fileType, filePath } = fileElement.dataset;

                const modalBody = document.querySelector('#previewModal .modal-body');
                document.getElementById('previewModalLabel').textContent = fileName;
                document.getElementById('modalDownloadBtn').href = filePath;

                // Only show the 'Remove' button for files in the pending tab
                const isInPendingTab = fileElement.closest('#pending') !== null;
                document.getElementById('modalRemoveBtn').style.display = isInPendingTab ? 'inline-block' : 'none';

                if (fileType.startsWith('image/')) {
                    modalBody.innerHTML = `<img src="${filePath}" alt="Preview" class="img-fluid">`;
                } else {
                    modalBody.innerHTML = `<div class="text-center p-4"><i class="bi bi-file-earmark-text icon-preview"></i><p class="mt-3">No preview available.</p></div>`;
                }
                previewModal.show();
            }

            // Adds click and double-click event listeners to a file item
            function addFileItemEventListeners(fileItem) {
                fileItem.addEventListener('click', (event) => {
                    const container = fileItem.closest('.file-preview-container');
                    if (!event.ctrlKey && !event.metaKey) {
                        container.querySelectorAll('.file-preview-item.selected').forEach(item => {
                            if (item !== fileItem) item.classList.remove('selected');
                        });
                    }
                    fileItem.classList.toggle('selected');
                });
                fileItem.addEventListener('dblclick', () => showPreview(fileItem));
            }

            // --- INITIAL EVENT LISTENER ATTACHMENT ---
            document.querySelectorAll('.file-preview-item').forEach(addFileItemEventListeners);
            
            document.getElementById('fileUpload').onchange = handleFileUpload;
            document.getElementById('deleteBtnContainer').onclick = triggerDeleteConfirmation;

            // Listener for the final delete button in the confirmation modal
            confirmDeleteBtn.addEventListener('click', () => {
                if (typeof deleteActionCallback === 'function') {
                    deleteActionCallback();
                }
                deleteActionCallback = null;
                confirmDeleteModal.hide();
            });

            // Listener for the remove button inside the preview modal
            document.getElementById('modalRemoveBtn').addEventListener('click', () => {
                if (activeFileInModal) {
                    previewModal.hide();
                    deleteActionCallback = () => performDelete([activeFileInModal]);
                    confirmDeleteModal.show();
                }
            });

            // Hide delete icon if not on the pending tab
            const statusTabs = document.querySelectorAll('.status-tabs .nav-link');
            const deleteIcon = document.getElementById('deleteBtnContainer');
            statusTabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(event) {
                    if (event.target.id === 'pending-tab') {
                        deleteIcon.style.display = 'flex';
                    } else {
                        deleteIcon.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>
