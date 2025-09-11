<?php
session_start();
require_once 'config.php'; // Ensure this path is correct relative to the logout file

// Check if a user ID is set in the session
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Connect to the database
    // The 'config.php' should establish the $conn variable
    if (isset($conn)) {
        // Update the status to 'Inactive' and clear last_activity to mark the user as offline immediately
        $sql = "UPDATE users SET status = 'Inactive', last_activity = NULL WHERE id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();
        }
        $conn->close();
    }
}

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php");
exit;
?>

