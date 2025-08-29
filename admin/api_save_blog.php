<?php
// Always start the session first
session_start();

// Ensure the blogsData session variable exists and is an array
if (!isset($_SESSION['blogsData']) || !is_array($_SESSION['blogsData'])) {
    $_SESSION['blogsData'] = [];
}

// Get the raw POST data from the JavaScript fetch call
$json = file_get_contents('php://input');
// Decode the JSON into a PHP associative array
$data = json_decode($json, true);

// Basic validation: ensure we have a title
if (isset($data['title']) && !empty($data['title'])) {
    
    // In a real app, you'd get the next ID from the database. Here, we calculate it.
    $nextId = (count($_SESSION['blogsData']) > 0) ? max(array_column($_SESSION['blogsData'], 'id')) + 1 : 1;
    
    $newBlog = [
        'id' => $nextId,
        'title' => $data['title'],
        'summary' => $data['summary'] ?? '', // Use null coalescing for safety
        'heroMedia' => null, // File uploads are not handled in this simple API
        'sections' => $data['sections'] ?? []
    ];

    // Add the new blog to our session array
    $_SESSION['blogsData'][] = $newBlog;

    // Send a success response back to the JavaScript
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Blog saved successfully.', 'blog' => $newBlog]);

} else {
    // Send an error response
    header('Content-Type: application/json');
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Invalid data provided. Title is required.']);
}