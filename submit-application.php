<?php
// Include the database connection file
require_once 'config.php';

// Set the response header to JSON
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Basic validation to ensure all fields are present
    if (empty($data['email']) || empty($data['fullName']) || empty($data['phone']) || empty($data['address']) || empty($data['interestPathway']) || empty($data['findUs']) || empty($data['facebookLink'])) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Assign variables from the data array
    $email = $data['email'];
    $fullName = $data['fullName'];
    $phone = $data['phone'];
    $address = $data['address'];
    // Convert arrays of checkboxes to comma-separated strings for database storage
    $interestPathway = implode(', ', $data['interestPathway']);
    $findUs = implode(', ', $data['findUs']);
    $facebookLink = $data['facebookLink'];

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO client_applications (email, fullName, phone, address, interestPathway, findUs, facebookLink) VALUES (?, ?, ?, ?, ?, ?, ?)");
    // Bind the variables to the prepared statement as parameters
    $stmt->bind_param("sssssss", $email, $fullName, $phone, $address, $interestPathway, $findUs, $facebookLink);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Application submitted successfully!']);
    } else {
        // Provide an error message if the execution fails
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
} else {
    // If the request method is not POST, return an error
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
