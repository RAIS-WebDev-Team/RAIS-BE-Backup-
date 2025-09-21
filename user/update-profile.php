<?php
// update-profile.php - Handles profile update logic

session_start();
include_once '../config.php';

// Set header for JSON response, as the frontend expects it
header('Content-Type: application/json');

// Helper function to standardize JSON responses
function send_json_response($status, $message) {
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(401); // Unauthorized
    send_json_response('error', 'Authentication required.');
}

$userId = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- Retrieve all form data safely ---
    $firstName = $_POST['firstName'] ?? null;
    $lastName = $_POST['lastName'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $address = $_POST['address'] ?? null;
    $birthday = $_POST['birthday'] ?? null; // Field from your script
    $facebook = $_POST['facebook'] ?? null;
    $instagram = $_POST['instagram'] ?? null;
    // --- FIX: Changed 'gmail' to 'email' to match the database and form ---
    $email = $_POST['email'] ?? null; 

    // --- Logic to determine progress ---
    $profilePictureUploaded = false;
    $birthdayAdded = !empty($birthday);
    // Corrected to check for email, facebook, or instagram for social links
    $socialLinksAdded = !empty($facebook) || !empty($instagram) || !empty($email);

    // --- Handle file upload ---
    $profileImagePath = null;
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
        $targetDir = "../uploads/";
        if (!file_exists($targetDir)) {
            // Added error handling for directory creation
            if (!mkdir($targetDir, 0777, true)) {
                send_json_response('error', 'Failed to create upload directory.');
            }
        }
        $fileName = uniqid() . '-' . basename($_FILES["profileImage"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array(strtolower($fileType), $allowTypes)) {
            if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFilePath)) {
                $profileImagePath = "uploads/" . $fileName;
                $profilePictureUploaded = true; // Set flag on successful upload
            } else {
                send_json_response('error', 'Failed to move uploaded file.');
            }
        } else {
             send_json_response('error', 'Invalid file type. Only JPG, PNG, JPEG, GIF are allowed.');
        }
    }

    // --- Prepare SQL statement to update the database ---
    $sqlParts = [
        "firstName = ?", "lastName = ?", "phone = ?", "address = ?", 
        "birthday = ?", "facebook = ?", "instagram = ?", "email = ?" // FIX: Using email column
    ];
    $params = [$firstName, $lastName, $phone, $address, $birthday, $facebook, $instagram, $email];
    $types = "ssssssss";

    // Fetch current flags to ensure we don't unset a completed step
    $stmt_check = $conn->prepare("SELECT profile_picture_uploaded, birthday_added, social_links_added FROM users WHERE id = ?");
    $stmt_check->bind_param("i", $userId);
    $stmt_check->execute();
    $currentUserFlags = $stmt_check->get_result()->fetch_assoc();
    $stmt_check->close();

    // Set flags to 1 if the action was just completed OR if it was already complete
    if ($profilePictureUploaded || ($currentUserFlags && $currentUserFlags['profile_picture_uploaded'])) {
        $sqlParts[] = "profile_picture_uploaded = 1";
    }
    if ($birthdayAdded || ($currentUserFlags && $currentUserFlags['birthday_added'])) {
        $sqlParts[] = "birthday_added = 1";
    }
    if ($socialLinksAdded || ($currentUserFlags && $currentUserFlags['social_links_added'])) {
        $sqlParts[] = "social_links_added = 1";
    }

    if ($profileImagePath) {
        $sqlParts[] = "profileImage = ?";
        $params[] = $profileImagePath;
        $types .= "s";
    }
    
    $params[] = $userId;
    $types .= "i";

    $sql = "UPDATE users SET " . implode(', ', $sqlParts) . " WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Check if the SQL statement was prepared successfully
    if ($stmt === false) {
        send_json_response('error', 'Database statement preparation failed: ' . $conn->error);
    }
    
    $stmt->bind_param($types, ...$params);

    // Execute the statement and return a JSON response instead of redirecting
    if ($stmt->execute()) {
        send_json_response('success', 'Profile updated successfully.');
    } else {
        send_json_response('error', 'Error updating record: ' . $stmt->error);
    }

    $stmt->close();
} else {
    http_response_code(405); // Method Not Allowed
    send_json_response('error', 'Invalid request method.');
}

$conn->close();
?>

