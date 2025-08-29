<?php
require_once '../config.php';

$page_title = "RAIS Admin - User Management";
$active_page = "user_management";
$active_threshold = 30; // in minutes

// Fetch all users from the database
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
                        <h2 class="mb-3 mb-md-0">All Users</h2>
                        <div class="input-group w-100" style="max-width: 400px;">
                            <input type="text" class="form-control" placeholder="Search by ID, name, or email..." id="searchInput">
                            <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                        </div>
                    </div>

                    <?php require_once '_user_table.php'; ?>

                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addUserModal" style="background-color: var(--rais-button-maroon); border: none;">Add New User</button>
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="addUserModalLabel">Add New User</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><form id="addUserForm"><div class="mb-3"><label for="addFirstName" class="form-label">First Name</label><input type="text" class="form-control" id="addFirstName" required></div><div class="mb-3"><label for="addLastName" class="form-label">Last Name</label><input type="text" class="form-control" id="addLastName" required></div><div class="mb-3"><label for="addEmail" class="form-label">Email address</label><input type="email" class="form-control" id="addEmail" required></div><div class="mb-3"><label for="addStatus" class="form-label">Status</label><select class="form-select" id="addStatus"><option>Active</option><option>Inactive</option></select></div></form></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="submit" form="addUserForm" class="btn btn-primary">Save User</button></div></div></div>
    </div>
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="editUserModalLabel">Edit User</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><form id="editUserForm"><input type="hidden" id="editUserId"><div class="mb-3"><label for="editFirstName" class="form-label">First Name</label><input type="text" class="form-control" id="editFirstName" required></div><div class="mb-3"><label for="editLastName" class="form-label">Last Name</label><input type="text" class="form-control" id="editLastName" required></div><div class="mb-3"><label for="editEmail" class="form-label">Email address</label><input type="email" class="form-control" id="editEmail" required></div><div class="mb-3"><label for="editStatus" class="form-label">Status</label><select class="form-select" id="editStatus"><option>Active</option><option>Inactive</option></select></div></form></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="submit" form="editUserForm" class="btn btn-primary">Save Changes</button></div></div></div>
    </div>
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="deleteModalBody">Are you sure you want to delete this user?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button></div></div></div>
    </div>
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="confirmationModalLabel">Success</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body">User details have been updated successfully.</div><div class="modal-footer"><button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button></div></div></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>
    <script src="/RAIS-Global/js/user_management.js" defer></script>
</body>
</html>