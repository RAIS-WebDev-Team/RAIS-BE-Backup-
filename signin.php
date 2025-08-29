<?php
// signin.php - Handles user authentication for different roles

// Start the session to store user login state.
// This must be at the very top of the script.
session_start();

// Include the database configuration file.
include 'config.php'; 

// Check if the form was submitted by checking for the 'login' post variable
if (isset($_POST['login'])) {
    // Sanitize the email input to prevent SQL injection.
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Prepare a statement to select the user and their role from the database by email.
    // We now also select the 'role' column.
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with that email exists.
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify that the submitted password matches the hashed password in the database.
        if (password_verify($password, $user['password'])) {
            // Password is correct.
            
            // Regenerate the session ID to prevent session fixation attacks.
            session_regenerate_id();
            
            // Store user data in the session, including the role.
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role']; // Store the user's role
            
            // === ROLE-BASED REDIRECTION ===
            // Check the user's role and redirect accordingly.
            if ($user['role'] === 'Super Admin') {
                // Redirect admin user to the admin dashboard.
                header("Location: admin/admin.php");
                exit(); // Stop script execution after redirect
            } else {
                // Redirect all other users (e.g., 'client') to the user dashboard.
                header("Location: user/dashboard.php");
                exit(); // Stop script execution after redirect
            }

        } else {
            // Invalid password
            // Store an error message in the session
            $_SESSION['login_error'] = "Invalid email or password.";
            // Redirect back to the login page
            header("Location: login.php");
            exit();
        }
    } else {
        // Invalid email
        // Store an error message in the session
        $_SESSION['login_error'] = "Invalid email or password.";
        // Redirect back to the login page
        header("Location: login.php");
        exit();
    }
    // Close the statement
    $stmt->close();
}
// Close the database connection
$conn->close();
?>