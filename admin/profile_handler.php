<?php
session_start();
require_once '../config.php';

$response = ['status' => 'error', 'message' => 'An unknown error occurred.'];

// Security Check: Ensure user is logged in and is an Admin
if (!isset($_SESSION['loggedin']) || strpos($_SESSION['role'], 'Admin') === false) {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $admin_id = $_SESSION['id'];
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Basic validation
    if (empty($firstName) || empty($lastName) || empty($email)) {
        $response['message'] = 'First Name, Last Name, and Email are required.';
        echo json_encode($response);
        exit;
    }

    $params = [$firstName, $lastName, $email, $phone, $address];
    $types = "sssss";
    $sql = "UPDATE users SET firstName = ?, lastName = ?, email = ?, phone = ?, address = ?";
    $profileImagePathForSession = null;

    // Handle file upload
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
        $targetDir = "../uploads/profiles/";
        if (!is_dir($targetDir)) { mkdir($targetDir, 0755, true); }
        
        $fileName = uniqid() . '-' . basename($_FILES["profileImage"]["name"]);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate file type
        if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
                // Path to store in the database (relative from project root)
                $profileImagePathForDB = "uploads/profiles/" . $fileName;
                $sql .= ", profileImage = ?";
                $params[] = $profileImagePathForDB;
                $types .= "s";
                // Path for immediate use in the session (relative from admin folder)
                $profileImagePathForSession = '../' . $profileImagePathForDB;
            } else {
                $response['message'] = 'Sorry, there was an error uploading your file.';
                echo json_encode($response);
                exit;
            }
        } else {
            $response['message'] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
            echo json_encode($response);
            exit;
        }
    }

    $sql .= " WHERE id = ?";
    $params[] = $admin_id;
    $types .= "i";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $response['message'] = "SQL Prepare failed: " . $conn->error;
        echo json_encode($response);
        exit;
    }
    
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        // Update session variables to reflect changes immediately
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        if ($profileImagePathForSession) {
            $_SESSION['profileImage'] = $profileImagePathForSession;
        }

        $response['status'] = 'success';
        $response['message'] = 'Profile updated successfully!';
    } else {
        $response['message'] = 'Failed to update profile. The email may already be in use.';
    }
    $stmt->close();
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>

