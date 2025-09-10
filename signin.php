<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role, firstName, lastName, profileImage FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $is_password_correct = false;

        // Check password based on role
        if (strpos($user['role'], 'Admin') !== false) {
            if ($password === $user['password']) { // Plain text for Admins
                $is_password_correct = true;
            }
        } else {
            if (password_verify($password, $user['password'])) { // Hashed for others
                $is_password_correct = true;
            }
        }

        if ($is_password_correct) {
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['lastName'] = $user['lastName'];
            $_SESSION['profileImage'] = $user['profileImage'];

            // Set status to Active and update timestamps
            $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW(), last_activity = NOW(), status = 'Active' WHERE id = ?");
            $update_stmt->bind_param("i", $user['id']);
            $update_stmt->execute();
            $update_stmt->close();

            // Redirect based on role
            if (strpos($user['role'], 'Admin') !== false) {
                header("Location: admin/admin.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit();
        }
    }

    // If login fails
    $_SESSION['login_error'] = "Invalid email or password.";
    header("Location: login.php");
    exit();
}
$conn->close();
?>

