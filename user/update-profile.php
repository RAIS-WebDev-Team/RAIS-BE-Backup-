<?php
// update-profile.php - Handles profile update logic

session_start();
include_once '../config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../login.php");
    exit;
}

$userId = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- Retrieve all form data ---
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];
    $gmail = $_POST['gmail'];

    // --- Logic to determine progress ---
    $profilePictureUploaded = false;
    $birthdayAdded = !empty($birthday);
    $socialLinksAdded = !empty($facebook) || !empty($instagram) || !empty($gmail);

    // --- Handle file upload ---
    $profileImagePath = null;
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
        $targetDir = "../uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = uniqid() . '-' . basename($_FILES["profileImage"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array(strtolower($fileType), $allowTypes)) {
            if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFilePath)) {
                $profileImagePath = "uploads/" . $fileName;
                $profilePictureUploaded = true; // Set flag on successful upload
            }
        }
    }

    // --- Prepare SQL statement to update the database ---
    $sqlParts = [
        "firstName = ?", "lastName = ?", "phone = ?", "address = ?", 
        "birthday = ?", "facebook = ?", "instagram = ?", "gmail = ?"
    ];
    $params = [$firstName, $lastName, $phone, $address, $birthday, $facebook, $instagram, $gmail];
    $types = "ssssssss";

    // Fetch current flags to ensure we don't unset a completed step
    $stmt_check = $conn->prepare("SELECT profile_picture_uploaded, birthday_added, social_links_added FROM users WHERE id = ?");
    $stmt_check->bind_param("i", $userId);
    $stmt_check->execute();
    $currentUserFlags = $stmt_check->get_result()->fetch_assoc();
    $stmt_check->close();

    // Set flags to 1 if the action was just completed OR if it was already complete
    if ($profilePictureUploaded || $currentUserFlags['profile_picture_uploaded']) {
        $sqlParts[] = "profile_picture_uploaded = 1";
    }
    if ($birthdayAdded || $currentUserFlags['birthday_added']) {
        $sqlParts[] = "birthday_added = 1";
    }
    if ($socialLinksAdded || $currentUserFlags['social_links_added']) {
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
    $stmt->bind_param($types, ...$params);

    // Execute the statement and redirect
    if ($stmt->execute()) {
        header("location: profile.php"); 
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
