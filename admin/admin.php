<?php

require_once '../config.php'; // Or your actual path to the connection file

// Page-specific data
$page_title = "RAIS Admin Dashboard";
// Define "active" as someone seen in the last 10 seconds.
$active_threshold = 15; // in seconds

// --- START: CONSOLIDATED REAL-TIME LOGIC ---

// PART A: Calculate the counts for the TOP SUMMARY CARDS
$sql_active = "SELECT COUNT(id) AS active_count FROM users WHERE last_activity >= NOW() - INTERVAL ? SECOND";
$stmt_active = $conn->prepare($sql_active);
$stmt_active->bind_param("i", $active_threshold);
$stmt_active->execute();
$result_active = $stmt_active->get_result();
$active_row = $result_active->fetch_assoc();
$active_users = $active_row['active_count'];
$stmt_active->close();

$sql_total = "SELECT COUNT(id) AS total_count FROM users";
$result_total = $conn->query($sql_total);
$total_row = $result_total->fetch_assoc();
$total_users = $total_row['total_count'];

$inactive_users = $total_users - $active_users;


// PART B: Fetch all user details for the USER MANAGEMENT TABLE
$users = [];
$sql_users = "SELECT id, firstName, lastName, email, status, last_login, role, last_activity FROM users ORDER BY id ASC";
if ($result = $conn->query($sql_users)) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $result->free();
} else {
    echo "ERROR: Could not execute user list query. " . $conn->error;
}

// Static data for other sections
$chat_logs = [
    ['user' => 'User 1', 'message' => 'Hello!'],
    ['user' => 'User 2', 'message' => 'I need assistance.'],
];
$latest_post_title = "A Long Road for 'A Calling to Canada'";

$conn->close();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../img/logoulit.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-wrapper">
        <?php require_once 'sidebar.php' ?>
        <div class="content-area">
            <?php require_once 'header.php' ?>
            <main class="main-content">
                <h1>Admin Dashboard</h1>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="content-card text-center">
                            <h2>Active Users</h2>
                            <h1 id="activeUserCount" class="display-4" style="color: #28a745;"><?php echo $active_users; ?></h1>
                            <p class="text-muted">Users active in the last <?php echo $active_threshold; ?> minutes.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content-card text-center">
                            <h2>Inactive Users</h2>
                            <h1 id="inactiveUserCount" class="display-4" style="color: #ffc107;"><?php echo $inactive_users; ?></h1>
                            <p class="text-muted">Users currently offline.</p>
                        </div>
                    </div>
                </div>

                <?php require_once '_user_table.php'; ?>

                <div class="content-card">
                    <h2>Live Chat Monitoring</h2>
                    </div>
                <div class="content-card my-3">
                    <h2>Content Management</h2>
                    </div>
            </main>
        </div>
    </div>
    
    <div class="modal fade" id="editUserModal" ...> ... </div>
    <div class="modal fade" id="deleteConfirmModal" ...> ... </div>
    <div class="modal fade" id="confirmationModal" ...> ... </div>
    <div class="modal fade" id="logoutConfirmModal" ...> ... </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>
    
    <script src="/RAIS-Global/js/user_management.js" defer></script>
    
    <script src="/RAIS-Global/js/admin_dashboard.js" defer></script>

</body>
</html>