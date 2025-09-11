<?php
session_start();
// Make sure to include your database configuration file
include 'config.php';

// Check if the form was submitted
if (isset($_POST['login'])) {
    // Sanitize user input
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Prepare and execute the statement to find the user by email
    $stmt = $conn->prepare("SELECT id, password, role, firstName, lastName, profileImage FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with that email exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        $password_verified = false;

        // --- SECURE PASSWORD VERIFICATION ---
        // First, try to verify the password as a modern hash.
        if (password_verify($password, $user['password'])) {
            $password_verified = true;
        } 
        // --- PASSWORD MIGRATION ---
        // If hash verification fails, check if it's an old plaintext password.
        // This handles legacy passwords and automatically upgrades them.
        else if ($password === $user['password']) {
            $password_verified = true;
            // Upgrade the plaintext password to a secure hash in the database.
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $update_hash_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_hash_stmt->bind_param("si", $new_hash, $user['id']);
            $update_hash_stmt->execute();
            $update_hash_stmt->close();
        }

        if ($password_verified) {
            // Password is correct, so start a new session
            session_regenerate_id(true); // Regenerate session ID for security
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['lastName'] = $user['lastName'];
            $_SESSION['profileImage'] = $user['profileImage'];

            // Update user status and login timestamps
            $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW(), last_activity = NOW(), status = 'Active' WHERE id = ?");
            $update_stmt->bind_param("i", $user['id']);
            $update_stmt->execute();
            $update_stmt->close();

            // --- REDIRECTION LOGIC ---
            // Redirect based on the user's role.
            if (stripos($user['role'], 'Admin') !== false) {
                header("Location: admin/admin.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit(); // Terminate script after redirect
        }
    }

    // If email is not found or password is incorrect, set an error message
    $_SESSION['login_error'] = "Invalid email or password.";
    header("Location: login.php");
    exit(); // Terminate script after redirect
}

// Close the database connection if the script reaches this point
$conn->close();
?>

