<?php
session_start();
require_once '../config.php';

$response = ['status' => 'error', 'message' => 'An unknown error occurred.'];

// Security Check: Ensure user is logged in and is a Super Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'Super Admin') {
    $response['message'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    // --- Shared Variables ---
    $id = $_POST['id'] ?? null;
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $type = $_POST['type'] ?? 'Admin'; 
    $password = $_POST['password'] ?? '';

    // --- Action: Add Admin ---
    if ($action === 'add_admin') {
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            $response['message'] = 'All fields including password are required for a new admin.';
        } else {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $response['message'] = 'An account with this email already exists.';
            } else {
                $passwordToStore = ($type === 'Super Admin') ? $password : password_hash($password, PASSWORD_DEFAULT);
                $profileImagePath = null;

                if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
                    $targetDir = "../uploads/profiles/";
                    if (!is_dir($targetDir)) { mkdir($targetDir, 0755, true); }
                    $fileName = uniqid() . '-' . basename($_FILES["profileImage"]["name"]);
                    $targetFile = $targetDir . $fileName;
                    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
                        $profileImagePath = "uploads/profiles/" . $fileName;
                    }
                }

                // Set new admin status to 'Inactive' by default
                $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, role, password, profileImage, status) VALUES (?, ?, ?, ?, ?, ?, 'Inactive')");
                $stmt->bind_param("ssssss", $firstName, $lastName, $email, $type, $passwordToStore, $profileImagePath);
                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Admin account created successfully!';
                } else {
                    $response['message'] = 'Database error: Could not create account.';
                }
            }
            $stmt->close();
        }
    }
    // --- Action: Edit Admin ---
    elseif ($action === 'edit_admin' && !empty($id)) {
        if (empty($firstName) || empty($lastName) || empty($email)) {
             $response['message'] = 'First Name, Last Name, and Email cannot be empty.';
        } else {
            $sql = "UPDATE users SET firstName = ?, lastName = ?, email = ?, role = ?";
            $params = [$firstName, $lastName, $email, $type];
            $types = "ssss";

            if (!empty($password)) {
                $passwordToStore = ($type === 'Super Admin') ? $password : password_hash($password, PASSWORD_DEFAULT);
                $sql .= ", password = ?";
                $params[] = $passwordToStore;
                $types .= "s";
            }

            if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
                $targetDir = "../uploads/profiles/";
                 if (!is_dir($targetDir)) { mkdir($targetDir, 0755, true); }
                $fileName = uniqid() . '-' . basename($_FILES["profileImage"]["name"]);
                $targetFile = $targetDir . $fileName;
                if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
                    $profileImagePath = "uploads/profiles/" . $fileName;
                    $sql .= ", profileImage = ?";
                    $params[] = $profileImagePath;
                    $types .= "s";
                }
            }

            $sql .= " WHERE id = ?";
            $params[] = $id;
            $types .= "i";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Admin account updated successfully!';
            } else {
                $response['message'] = 'Database error: Could not update account. The email may be taken.';
            }
            $stmt->close();
        }
    }
    // --- Action: Delete Admin ---
    elseif ($action === 'delete_admin' && !empty($id)) {
        if ($id == $_SESSION['id']) {
            $response['message'] = 'You cannot delete your own account.';
        } else {
            $stmt = $conn->prepare("SELECT COUNT(id) AS superAdminCount FROM users WHERE role = 'Super Admin'");
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            
            $stmt_check_role = $conn->prepare("SELECT role FROM users WHERE id = ?");
            $stmt_check_role->bind_param("i", $id);
            $stmt_check_role->execute();
            $user_to_delete = $stmt_check_role->get_result()->fetch_assoc();

            if ($result['superAdminCount'] <= 1 && $user_to_delete['role'] === 'Super Admin') {
                $response['message'] = 'You cannot delete the last Super Admin account.';
            } else {
                $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Admin account deleted successfully!';
                } else {
                    $response['message'] = 'Database error: Could not delete account.';
                }
            }
            $stmt->close();
        }
    }
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>

