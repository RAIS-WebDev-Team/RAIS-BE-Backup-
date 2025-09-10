<?php
// --- SESSION AND SECURITY CHECK ---
// Start the session at the very beginning of the script.
session_start();

// Check if the user is logged in and has an Admin role.
// If not, redirect them to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || strpos($_SESSION['role'], 'Admin') === false) {
    header("location: ../login.php");
    exit; // Stop script execution immediately.
}


require_once '../config.php'; // Or your actual path to the connection file

// Page-specific data
$page_title = "RAIS Admin Dashboard";
$active_page = "dashboard";
// Define "active" as someone seen in the last 15 seconds.
$active_threshold = 15; // in seconds

// --- START: DATA FETCHING ---

// PART A: Calculate the counts for the TOP SUMMARY CARDS for the initial page load.
$sql_active = "SELECT COUNT(id) AS active_count FROM users WHERE last_activity >= NOW() - INTERVAL ? SECOND AND role LIKE '%Client%'";
$stmt_active = $conn->prepare($sql_active);
$stmt_active->bind_param("i", $active_threshold);
$stmt_active->execute();
$result_active = $stmt_active->get_result();
$active_row = $result_active->fetch_assoc();
$active_users = $active_row['active_count'];
$stmt_active->close();

$sql_total = "SELECT COUNT(id) AS total_count FROM users WHERE role LIKE '%Client%'";
$result_total = $conn->query($sql_total);
$total_row = $result_total->fetch_assoc();
$total_users = $total_row['total_count'];

$inactive_users = $total_users - $active_users;


// PART B: Fetch all user details for the USER MANAGEMENT TABLE, filtering for Clients only.
$users = [];
$sql_users = "SELECT id, firstName, lastName, email, status, last_login, role, last_activity, profileImage FROM users WHERE role LIKE '%Client%' ORDER BY id ASC";
if ($result = $conn->query($sql_users)) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $result->free();
} else {
    echo "ERROR: Could not execute user list query. " . $conn->error;
}

// PART C: Fetch latest chat messages for LIVE CHAT MONITORING
$chat_logs = [];
// This query uses a more robust method (window functions) to get the latest message from each client.
$sql_chat = "
    WITH RankedMessages AS (
        SELECT
            sender_id,
            message,
            timestamp,
            id,
            ROW_NUMBER() OVER(PARTITION BY sender_id ORDER BY timestamp DESC, id DESC) as rn
        FROM chat_messages
    )
    SELECT
        u.firstName, u.lastName, u.profileImage, rm.message, rm.timestamp
    FROM RankedMessages rm
    JOIN users u ON rm.sender_id = u.id
    WHERE rm.rn = 1 AND u.role LIKE '%Client%'
    ORDER BY rm.timestamp DESC";

// We wrap this in a try-catch block in case the chat_messages table doesn't exist yet.
try {
    if ($result_chat = $conn->query($sql_chat)) {
        while ($row = $result_chat->fetch_assoc()) {
            $chat_logs[] = $row;
        }
        $result_chat->free();
    }
} catch (Exception $e) {
    // Table likely doesn't exist, so we'll just have an empty $chat_logs array.
    // This prevents the page from crashing if the chat feature isn't fully set up.
}

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
    <style>
        .chat-avatar {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border: 2px solid #dee2e6; /* Light border for visibility on any background */
        }
        body.dark-mode .chat-avatar {
            border-color: #495057; /* Darker border for dark mode */
        }
        
        /* Dark mode styles for Live Chat Monitoring */
        body.dark-mode .live-chat-card {
            background-color: #212529; /* A dark gray background */
        }
        body.dark-mode .live-chat-card h2,
        body.dark-mode .live-chat-card .fw-bold,
        body.dark-mode .live-chat-card .list-group-item {
            color: #fff; /* White text for better contrast */
        }
        body.dark-mode .live-chat-card .text-muted {
            color: #adb5bd !important; /* A softer white for muted text */
        }
        body.dark-mode .list-group-item {
            background-color: transparent; /* Makes list items use the card's background */
            border-color: #495057;
        }
        .table-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
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
                            <p class="text-muted">Users active in the last <?php echo $active_threshold; ?> seconds.</p>
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

                <div class="content-card">
                    <h2 class="mb-3">User Management</h2>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Last Seen</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="user-table-body">
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr data-user-id="<?php echo $user['id']; ?>">
                                            <td>
                                                <?php
                                                    $table_avatar_path = !empty($user['profileImage']) ? '../' . htmlspecialchars($user['profileImage']) : 'https://placehold.co/40x40/666777/FFF?text=??';
                                                ?>
                                                <img src="<?php echo $table_avatar_path; ?>" alt="Avatar" class="table-avatar" onerror="this.onerror=null;this.src='https://placehold.co/40x40/666777/FFF?text=??';">
                                            </td>
                                            <td data-field="name"><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></td>
                                            <td data-field="email"><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td>
                                                <?php
                                                    $is_active = false;
                                                    if ($user['last_activity']) {
                                                        $last_activity_time = strtotime($user['last_activity']);
                                                        if (time() - $last_activity_time < $active_threshold) {
                                                            $is_active = true;
                                                        }
                                                    }
                                                    echo $is_active ? '<span class="badge bg-success">Online</span>' : '<span class="badge bg-secondary">Offline</span>';
                                                ?>
                                            </td>
                                            <td><?php echo $user['last_activity'] ? date('M j, Y, g:i a', strtotime($user['last_activity'])) : 'Never'; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary edit-user-btn" 
                                                    data-user-id="<?php echo $user['id']; ?>"
                                                    data-first-name="<?php echo htmlspecialchars($user['firstName']); ?>"
                                                    data-last-name="<?php echo htmlspecialchars($user['lastName']); ?>"
                                                    data-email="<?php echo htmlspecialchars($user['email']); ?>">
                                                    Edit
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger delete-user-btn"
                                                    data-user-id="<?php echo $user['id']; ?>"
                                                    data-user-name="<?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No client users found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="content-card live-chat-card mt-4">
                    <h2>Live Chat Monitoring</h2>
                    <?php if (!empty($chat_logs)): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($chat_logs as $log): ?>
                                <li class="list-group-item px-0 d-flex align-items-start">
                                    <?php
                                        // Set path for profile pic, with a fallback to a default avatar.
                                        $profile_pic_path = !empty($log['profileImage']) ? '../' . htmlspecialchars($log['profileImage']) : 'https://placehold.co/45x45/666777/FFF?text=??';
                                    ?>
                                    <img src="<?php echo $profile_pic_path; ?>" alt="Profile Picture" class="rounded-circle me-3 chat-avatar" onerror="this.onerror=null;this.src='https://placehold.co/45x45/666777/FFF?text=??';">
                                    
                                    <div class="w-100">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-1 fw-bold"><?php echo htmlspecialchars($log['firstName'] . ' ' . $log['lastName']); ?></p>
                                            <small class="text-muted"><?php echo date('M j, g:i A', strtotime($log['timestamp'])); ?></small>
                                        </div>
                                        <p class="mb-1 text-muted small">
                                            <?php 
                                                // Truncate message for preview
                                                $message = htmlspecialchars($log['message']);
                                                echo (strlen($message) > 100) ? substr($message, 0, 100) . '...' : $message;
                                            ?>
                                        </p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-center text-muted mt-3">No recent chat messages from clients.</p>
                    <?php endif; ?>
                </div>
                <div class="content-card my-3">
                    <h2>Content Management</h2>
                    </div>
            </main>
        </div>
    </div>
    
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editUserForm">
              <input type="hidden" id="editUserId" name="userId">
              <div class="mb-3">
                <label for="editFirstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="editFirstName" name="firstName" required>
              </div>
              <div class="mb-3">
                <label for="editLastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="editLastName" name="lastName" required>
              </div>
              <div class="mb-3">
                <label for="editEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="editEmail" name="email" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete the user <strong id="userNameToDelete"></strong>? This action cannot be undone.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="confirmationModal" tabindex="-1"></div>
    <div class="modal fade" id="logoutConfirmModal" tabindex="-1"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>
    
    <!-- This script makes the user counts update in real-time -->
    <script src="../js/admin_dashboard.js" defer></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        const editUserForm = document.getElementById('editUserForm');
        const userTableBody = document.getElementById('user-table-body');

        userTableBody.addEventListener('click', function(event) {
            if (event.target.classList.contains('edit-user-btn')) {
                const button = event.target;
                
                const userId = button.dataset.userId;
                const firstName = button.dataset.firstName;
                const lastName = button.dataset.lastName;
                const email = button.dataset.email;

                // Populate the modal form
                document.getElementById('editUserId').value = userId;
                document.getElementById('editFirstName').value = firstName;
                document.getElementById('editLastName').value = lastName;
                document.getElementById('editEmail').value = email;

                editUserModal.show();
            }
        });

        editUserForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(editUserForm);
            
            fetch('update_user.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    editUserModal.hide();
                    
                    // Find the row in the table to update
                    const rowToUpdate = userTableBody.querySelector(`tr[data-user-id='${formData.get('userId')}']`);
                    if(rowToUpdate) {
                        const newFirstName = formData.get('firstName');
                        const newLastName = formData.get('lastName');
                        const newEmail = formData.get('email');

                        // Update the button's data attributes for the next edit
                        const editButton = rowToUpdate.querySelector('.edit-user-btn');
                        editButton.dataset.firstName = newFirstName;
                        editButton.dataset.lastName = newLastName;
                        editButton.dataset.email = newEmail;
                        
                        // Update the displayed text in the table cells
                        rowToUpdate.querySelector('td[data-field="name"]').textContent = newFirstName + ' ' + newLastName;
                        rowToUpdate.querySelector('td[data-field="email"]').textContent = newEmail;
                    }

                } else {
                    alert('Error updating user: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        // --- DELETE USER SCRIPT ---
        const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        let userIdToDelete = null;

        userTableBody.addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-user-btn')) {
                const button = event.target;
                userIdToDelete = button.dataset.userId;
                const userName = button.dataset.userName;

                document.getElementById('userNameToDelete').textContent = userName;
                deleteConfirmModal.show();
            }
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (!userIdToDelete) return;

            const formData = new FormData();
            formData.append('userId', userIdToDelete);

            fetch('delete_user.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    deleteConfirmModal.hide();
                    
                    const rowToDelete = userTableBody.querySelector(`tr[data-user-id='${userIdToDelete}']`);
                    if (rowToDelete) {
                        rowToDelete.remove();
                    }
                    userIdToDelete = null; 
                } else {
                    alert('Error deleting user: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    });
    </script>

</body>
</html>
