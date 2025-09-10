<?php
session_start();
require_once '../config.php';

// Security Check: Ensure user is logged in and is an Admin
if (!isset($_SESSION['loggedin']) || strpos($_SESSION['role'], 'Admin') === false) {
    header("Location: ../login.php");
    exit;
}

$page_title = "RAIS Admin - User Management";
$active_page = "user_management";
$active_threshold = 300; // Users active in the last 300 seconds (5 minutes)

// Fetch all users from the database, filtering for clients and getting profile images
$users = [];
$sql_users = "SELECT id, firstName, lastName, email, last_activity, profileImage FROM users WHERE role LIKE '%Client%' ORDER BY id ASC";
if ($result = $conn->query($sql_users)) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $result->free();
} else {
    echo "ERROR: Could not execute user list query. " . $conn->error;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img/logoulit.png" />
    <link rel="stylesheet" href="style.css">
    <style>
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
        <?php require_once 'sidebar.php'; ?>
        <div class="content-area">
            <?php require_once 'header.php'; ?>
            <main class="main-content">
                <h1>User Management</h1>

                <div class="content-card">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <h2 class="mb-3 mb-md-0">All Client Users</h2>
                        <div class="input-group w-100" style="max-width: 400px;">
                            <input type="text" class="form-control" placeholder="Search by ID, name, or email..." id="searchInput">
                            <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
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
                                                    $avatar_path = !empty($user['profileImage']) ? '../' . htmlspecialchars($user['profileImage']) : 'https://placehold.co/40x40/666777/FFF?text=??';
                                                ?>
                                                <img src="<?php echo $avatar_path; ?>" alt="Avatar" class="table-avatar" onerror="this.onerror=null;this.src='https://placehold.co/40x40/666777/FFF?text=??';">
                                            </td>
                                            <td><?php echo $user['id']; ?></td>
                                            <td data-field="name"><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></td>
                                            <td data-field="email"><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td>
                                                <?php
                                                    $is_online = false;
                                                    if ($user['last_activity']) {
                                                        $last_activity_time = strtotime($user['last_activity']);
                                                        if (time() - $last_activity_time < $active_threshold) {
                                                            $is_online = true;
                                                        }
                                                    }
                                                    echo $is_online ? '<span class="badge bg-success">Online</span>' : '<span class="badge bg-secondary">Offline</span>';
                                                ?>
                                            </td>
                                            <td><?php echo $user['last_activity'] ? date('M j, Y, g:i a', strtotime($user['last_activity'])) : 'Never'; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary edit-user-btn" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editUserModal"
                                                        data-user-id="<?php echo $user['id']; ?>"
                                                        data-first-name="<?php echo htmlspecialchars($user['firstName']); ?>"
                                                        data-last-name="<?php echo htmlspecialchars($user['lastName']); ?>"
                                                        data-email="<?php echo htmlspecialchars($user['email']); ?>">Edit</button>
                                                <button class="btn btn-sm btn-outline-danger delete-user-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteConfirmModal"
                                                        data-user-id="<?php echo $user['id']; ?>"
                                                        data-name="<?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No client users found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addUserModal" style="background-color: var(--rais-button-maroon); border: none;">Add New User</button>
                </div>
            </main>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="addUserModalLabel">Add New User</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><form id="addUserForm"><div class="mb-3"><label for="addFirstName" class="form-label">First Name</label><input type="text" class="form-control" id="addFirstName" name="firstName" required></div><div class="mb-3"><label for="addLastName" class="form-label">Last Name</label><input type="text" class="form-control" id="addLastName" name="lastName" required></div><div class="mb-3"><label for="addEmail" class="form-label">Email address</label><input type="email" class="form-control" id="addEmail" name="email" required></div><div class="mb-3"><label for="addPassword" class="form-label">Password</label><input type="password" class="form-control" id="addPassword" name="password" required></div></form></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="submit" form="addUserForm" class="btn btn-primary">Save User</button></div></div></div>
    </div>
    
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="editUserModalLabel">Edit User</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><form id="editUserForm"><input type="hidden" id="editUserId" name="userId"><div class="mb-3"><label for="editFirstName" class="form-label">First Name</label><input type="text" class="form-control" id="editFirstName" name="firstName" required></div><div class="mb-3"><label for="editLastName" class="form-label">Last Name</label><input type="text" class="form-control" id="editLastName" name="lastName" required></div><div class="mb-3"><label for="editEmail" class="form-label">Email address</label><input type="email" class="form-control" id="editEmail" name="email" required></div></form></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="submit" form="editUserForm" class="btn btn-primary">Save Changes</button></div></div></div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="deleteModalBody">Are you sure you want to delete this user?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button></div></div></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const userTableBody = document.getElementById('user-table-body');
        const searchInput = document.getElementById('searchInput');

        // Modals
        const addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
        const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

        // Forms
        const addUserForm = document.getElementById('addUserForm');
        const editUserForm = document.getElementById('editUserForm');

        let userIdToDelete = null;

        // --- Search Functionality ---
        searchInput.addEventListener('keyup', function () {
            const searchTerm = searchInput.value.toLowerCase();
            const tableRows = userTableBody.getElementsByTagName('tr');

            for (let row of tableRows) {
                const idText = row.cells[1].textContent.toLowerCase();
                const nameText = row.cells[2].textContent.toLowerCase();
                const emailText = row.cells[3].textContent.toLowerCase();
                if (idText.includes(searchTerm) || nameText.includes(searchTerm) || emailText.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });

        // --- Add User ---
        addUserForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(addUserForm);

            fetch('add_user.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Could not add user.'));
                }
            })
            .catch(() => alert('An unexpected network error occurred.'));
        });

        // --- Event Delegation for Edit and Delete ---
        userTableBody.addEventListener('click', function (e) {
            const target = e.target.closest('button');
            if (!target) return;

            // --- Edit User Button Click ---
            if (target.classList.contains('edit-user-btn')) {
                document.getElementById('editUserId').value = target.dataset.userId;
                document.getElementById('editFirstName').value = target.dataset.firstName;
                document.getElementById('editLastName').value = target.dataset.lastName;
                document.getElementById('editEmail').value = target.dataset.email;
            }

            // --- Delete User Button Click ---
            if (target.classList.contains('delete-user-btn')) {
                userIdToDelete = target.dataset.userId;
                document.getElementById('deleteModalBody').textContent = `Are you sure you want to delete the user: ${target.dataset.name}?`;
            }
        });

        // --- Edit User Form Submission ---
        editUserForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(editUserForm);
            
            fetch('update_user.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    editUserModal.hide();
                    
                    const userId = formData.get('userId');
                    const rowToUpdate = userTableBody.querySelector(`tr[data-user-id='${userId}']`);
                    
                    if (rowToUpdate) {
                        const newFirstName = formData.get('firstName');
                        const newLastName = formData.get('lastName');
                        const newEmail = formData.get('email');

                        rowToUpdate.querySelector('td[data-field="name"]').textContent = `${newFirstName} ${newLastName}`;
                        rowToUpdate.querySelector('td[data-field="email"]').textContent = newEmail;

                        const editButton = rowToUpdate.querySelector('.edit-user-btn');
                        editButton.dataset.firstName = newFirstName;
                        editButton.dataset.lastName = newLastName;
                        editButton.dataset.email = newEmail;
                    }
                } else {
                    alert('Error updating user: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(() => alert('An unexpected network error occurred.'));
        });

        // --- Confirm Deletion ---
        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            if (!userIdToDelete) return;

            const formData = new FormData();
            formData.append('userId', userIdToDelete);

            fetch('delete_user.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                deleteConfirmModal.hide();
                if (data.status === 'success') {
                    userTableBody.querySelector(`tr[data-user-id='${userIdToDelete}']`).remove();
                } else {
                    alert('Error: ' + (data.message || 'Could not delete user.'));
                }
                userIdToDelete = null;
            })
            .catch(() => {
                deleteConfirmModal.hide();
                alert('An unexpected network error occurred.');
            });
        });
    });
    </script>
</body>
</html>

