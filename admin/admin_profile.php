<?php
session_start();
require_once '../config.php';

// Security Check: User must be logged in.
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

$page_title = "RAIS Admin - Admin Profile Management";
$active_page = "admin_profile";
$current_user_id = $_SESSION['id'];
$user_role = $_SESSION['role'];

// --- Authorization & Action Handling ---
$has_access = false;
$request_status = '';

// Super Admins always have access.
if ($user_role === 'Super Admin') {
    $has_access = true;

    // Handle approval/denial actions from Super Admin
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'], $_POST['action'])) {
        $request_id = $_POST['request_id'];
        $action = $_POST['action'];
        $status = ($action === 'approve') ? 'approved' : 'denied';
        $super_admin_id = $_SESSION['id'];

        $stmt = $conn->prepare("UPDATE admin_access_requests SET status = ?, authorized_by_superadmin_id = ?, authorized_at = NOW() WHERE id = ? AND status = 'pending'");
        $stmt->bind_param("sii", $status, $super_admin_id, $request_id);
        $stmt->execute();
        $stmt->close();

        // Redirect to the same page to prevent form resubmission
        header("Location: admin_profile.php");
        exit;
    }
} 
// Regular Admins need to check for an approved request.
elseif ($user_role === 'Admin') {
    // Check for a recent approved request (valid for 1 hour)
    $stmt = $conn->prepare("SELECT status FROM admin_access_requests WHERE admin_user_id = ? AND status = 'approved' AND authorized_at >= NOW() - INTERVAL 1 HOUR ORDER BY authorized_at DESC LIMIT 1");
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $has_access = true;
    } else {
        // Check for the latest request status to display to the Admin
        $stmt = $conn->prepare("SELECT status FROM admin_access_requests WHERE admin_user_id = ? ORDER BY requested_at DESC LIMIT 1");
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $request_status = $result->num_rows > 0 ? $result->fetch_assoc()['status'] : '';
    }
    $stmt->close();
}

// Handle a new access request from an Admin.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_access']) && $user_role === 'Admin') {
    $stmt = $conn->prepare("INSERT INTO admin_access_requests (admin_user_id, status) VALUES (?, 'pending')");
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_profile.php");
    exit;
}

// --- Data Fetching ---
$adminAccounts = [];
$pending_requests = [];

// Fetch admin accounts list if the user has access.
if ($has_access) {
    $sql = "SELECT id, firstName, lastName, email, profileImage, role AS type, status FROM users WHERE role LIKE '%Admin%' ORDER BY id ASC";
    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            if ($row['profileImage']) {
                $row['profileImage'] = '../' . $row['profileImage'];
            }
            $adminAccounts[] = $row;
        }
        $result->free();
    }
}

// Fetch pending requests ONLY if the user is a Super Admin.
if ($user_role === 'Super Admin') {
    $sql_requests = "SELECT r.id, r.requested_at, u.firstName, u.lastName, u.email 
                     FROM admin_access_requests r
                     JOIN users u ON r.admin_user_id = u.id
                     WHERE r.status = 'pending'
                     ORDER BY r.requested_at ASC";
    if ($result = $conn->query($sql_requests)) {
        while ($row = $result->fetch_assoc()) {
            $pending_requests[] = $row;
        }
        $result->free();
    }
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-table-image { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; }
        .admin-profile-image-preview { width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 2px solid #dee2e6; }
        .authorization-card { max-width: 600px; margin: 50px auto; }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <?php require_once 'sidebar.php'; ?>
        <div class="content-area">
            <?php require_once 'header.php'; ?>
            <main class="main-content">
                <h1>Admin Profile Management</h1>

                <?php if ($has_access) : ?>
                    <!-- Main Content for Authorized Users -->
                    
                    <!-- Authorization Section (Super Admin Only) -->
                    <?php if ($user_role === 'Super Admin') : ?>
                    <div class="content-card mb-4">
                        <h2>Pending Access Requests</h2>
                        <?php if (empty($pending_requests)) : ?>
                            <div class="alert alert-success mt-3" role="alert">
                                There are no pending access requests.
                            </div>
                        <?php else : ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Admin Name</th>
                                            <th>Email</th>
                                            <th>Requested At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pending_requests as $request) : ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($request['firstName'] . ' ' . $request['lastName']); ?></td>
                                                <td><?php echo htmlspecialchars($request['email']); ?></td>
                                                <td><?php echo date('F j, Y, g:i a', strtotime($request['requested_at'])); ?></td>
                                                <td>
                                                    <form method="POST" action="admin_profile.php" class="d-inline">
                                                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                                        <button type="submit" name="action" value="approve" class="btn btn-sm btn-success"><i class="bi bi-check-circle-fill me-1"></i>Approve</button>
                                                    </form>
                                                    <form method="POST" action="admin_profile.php" class="d-inline">
                                                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                                        <button type="submit" name="action" value="deny" class="btn btn-sm btn-danger"><i class="bi bi-x-circle-fill me-1"></i>Deny</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Existing Admin Accounts Section -->
                    <div class="content-card">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                            <h2 class="mb-3 mb-md-0">Existing Admin Accounts</h2>
                            <div class="input-group w-100" style="max-width: 400px;">
                                <input type="text" class="form-control" placeholder="Search by name or email..." id="searchInput">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th><th>ID</th><th>Name</th><th>Email</th><th>Type</th><th>Status</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="adminAccountsTableBody"></tbody>
                            </table>
                        </div>
                        <button class="btn btn-primary mt-3" id="addNewAdminBtn" style="background-color: var(--rais-button-maroon);">Add New Admin</button>
                    </div>

                <?php elseif ($user_role === 'Admin') : ?>
                    <!-- Authorization Request Area for Admins -->
                    <div class="card authorization-card">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-shield-lock-fill text-warning" style="font-size: 4rem;"></i>
                            <h2 class="card-title mt-3">Authorization Required</h2>
                            <p class="text-muted">You need approval from a Super Admin to access this page.</p>
                            
                            <?php if ($request_status === 'pending') : ?>
                                <div class="alert alert-info">
                                    Your access request has been sent and is currently pending approval. Please check back later.
                                </div>
                            <?php elseif ($request_status === 'denied') : ?>
                                <div class="alert alert-danger">
                                    Your previous access request was denied. You may request access again.
                                </div>
                                <form method="POST" action="admin_profile.php">
                                    <button type="submit" name="request_access" class="btn btn-primary" style="background-color: var(--rais-button-maroon);">Request Access Again</button>
                                </form>
                            <?php else : ?>
                                <form method="POST" action="admin_profile.php">
                                    <button type="submit" name="request_access" class="btn btn-primary" style="background-color: var(--rais-button-maroon);">Request Access</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php else : ?>
                    <!-- Access Denied for Other Roles -->
                    <div class="alert alert-danger">You do not have permission to view this page.</div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <!-- Modals (only load if user has access) -->
    <?php if ($has_access) : ?>
    <div class="modal fade" id="adminModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="adminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminModalLabel">Add New Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adminForm" novalidate>
                        <input type="hidden" id="adminId" name="id">
                        <div class="mb-3 text-center">
                            <img id="adminImagePreview" src="https://placehold.co/120" alt="Admin Profile Preview" class="admin-profile-image-preview">
                            <input class="form-control mt-2" type="file" id="adminImageUpload" name="profileImage" accept="image/*">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="adminFirstName">First Name</label><input type="text" class="form-control" id="adminFirstName" name="firstName" required></div>
                            <div class="col-md-6 mb-3"><label for="adminLastName">Last Name</label><input type="text" class="form-control" id="adminLastName" name="lastName" required></div>
                        </div>
                        <div class="mb-3"><label for="adminEmail">Email</label><input type="email" class="form-control" id="adminEmail" name="email" required></div>
                        <div class="mb-3"><label for="adminType">Type</label><select class="form-select" id="adminType" name="type"><option>Admin</option><option>Super Admin</option></select></div>
                        <div class="mb-3"><label for="adminPassword">Password</label><input type="password" class="form-control" id="adminPassword" name="password"><small class="form-text text-muted">Leave blank if not changing.</small></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="saveAdminBtn" class="btn btn-primary" style="background-color: var(--rais-button-maroon);">Save Admin</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="deleteConfirmModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Confirmation Modal -->
    <div class="modal fade" id="saveConfirmModal" tabindex="-1" aria-labelledby="saveConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saveConfirmModalLabel">Confirm Save</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to save these changes?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmSaveBtn" style="background-color: var(--rais-button-maroon);">Confirm Save</button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>

    <?php if ($has_access) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // This script section remains largely unchanged, as it controls the admin management table.
            let allAdminAccounts = <?php echo json_encode($adminAccounts); ?>;
            const adminModal = new bootstrap.Modal(document.getElementById('adminModal'));
            const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            const saveConfirmModal = new bootstrap.Modal(document.getElementById('saveConfirmModal'));

            function renderAdminAccounts(accounts) {
                const tableBody = document.getElementById('adminAccountsTableBody');
                tableBody.innerHTML = '';
                if(accounts.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="7" class="text-center">No admin accounts found.</td></tr>';
                    return;
                }
                accounts.forEach(admin => {
                    const profileImageSrc = admin.profileImage || 'https://placehold.co/40x40/6c757d/FFFFFF?text=NA';
                    const row = `<tr data-admin-id="${admin.id}">
                        <td><img src="${profileImageSrc}" class="admin-table-image" onerror="this.src='https://placehold.co/40x40/6c757d/FFFFFF?text=NA'"></td>
                        <td>${admin.id}</td>
                        <td>${admin.firstName} ${admin.lastName}</td>
                        <td>${admin.email}</td>
                        <td>${admin.type}</td>
                        <td class="status-cell"><span class="badge bg-secondary">Offline</span></td>
                        <td>
                            <button class="btn btn-sm btn-info edit-btn" data-id="${admin.id}" title="Edit"><i class="bi bi-pencil-fill me-1"></i>Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${admin.id}" data-name="${admin.firstName} ${admin.lastName}" title="Delete"><i class="bi bi-trash-fill me-1"></i>Delete</button>
                        </td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });
                fetchAdminStatuses();
            }
            
            async function fetchAdminStatuses() {
                try {
                    const response = await fetch('get_admin_status.php'); // Assuming you have this file
                    if(!response.ok) return;
                    const statuses = await response.json();
                    if (statuses.status === 'success') {
                        updateStatusOnUI(statuses.data);
                    }
                } catch (error) {
                    console.error('Error fetching admin statuses:', error);
                }
            }
            
            function updateStatusOnUI(statusData) {
                document.querySelectorAll('#adminAccountsTableBody tr[data-admin-id]').forEach(row => {
                    const adminId = row.dataset.adminId;
                    const statusCell = row.querySelector('.status-cell');
                    if (statusData[adminId] && statusData[adminId].is_online) {
                        statusCell.innerHTML = `<span class="badge bg-success">Online</span>`;
                    } else {
                        statusCell.innerHTML = `<span class="badge bg-secondary">Offline</span>`;
                    }
                });
            }

            function openModalForEdit(adminId) {
                const admin = allAdminAccounts.find(a => a.id == adminId);
                if (!admin) return;

                document.getElementById('adminModalLabel').textContent = 'Edit Admin';
                document.getElementById('adminForm').reset();
                document.getElementById('adminId').value = admin.id;
                document.getElementById('adminFirstName').value = admin.firstName;
                document.getElementById('adminLastName').value = admin.lastName;
                document.getElementById('adminEmail').value = admin.email;
                document.getElementById('adminType').value = admin.type;
                document.getElementById('adminPassword').value = '';
                document.getElementById('adminPassword').placeholder = 'Leave blank to keep current';
                document.getElementById('adminImagePreview').src = admin.profileImage || 'https://placehold.co/120';
                adminModal.show();
            }

            function promptForDelete(adminId, adminName) {
                document.getElementById('deleteConfirmModalBody').textContent = `Are you sure you want to delete the admin account for ${adminName}? This action cannot be undone.`;
                document.getElementById('confirmDeleteBtn').dataset.id = adminId;
                deleteConfirmModal.show();
            }

            document.getElementById('addNewAdminBtn').addEventListener('click', () => {
                document.getElementById('adminModalLabel').textContent = 'Add New Admin';
                document.getElementById('adminForm').reset();
                document.getElementById('adminId').value = '';
                document.getElementById('adminPassword').placeholder = 'Enter new password';
                document.getElementById('adminImagePreview').src = 'https://placehold.co/120';
                adminModal.show();
            });

            document.getElementById('adminAccountsTableBody').addEventListener('click', function(e) {
                const editButton = e.target.closest('.edit-btn');
                if (editButton) {
                    openModalForEdit(editButton.dataset.id);
                }
                const deleteButton = e.target.closest('.delete-btn');
                if (deleteButton) {
                    promptForDelete(deleteButton.dataset.id, deleteButton.dataset.name);
                }
            });

            document.getElementById('adminImageUpload').addEventListener('change', function(event) {
                if (event.target.files && event.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => document.getElementById('adminImagePreview').src = e.target.result;
                    reader.readAsDataURL(event.target.files[0]);
                }
            });

            async function submitForm(action, formData) {
                try {
                    const response = await fetch('admin_profile_handler.php', { method: 'POST', body: formData });
                    const result = await response.json();

                    if (result.status === 'success') {
                        adminModal.hide();
                        deleteConfirmModal.hide();
                        alert(result.message);
                        window.location.reload(); 
                    } else {
                        alert('Error: ' + result.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An unexpected error occurred.');
                }
            }
            
            document.getElementById('saveAdminBtn').addEventListener('click', function() {
                const form = document.getElementById('adminForm');
                const action = form.querySelector('#adminId').value ? 'edit_admin' : 'add_admin';
                const passwordField = form.querySelector('#adminPassword');
                
                if (action === 'add_admin' && !passwordField.value) {
                    alert('Password is required for new admin accounts.');
                    return;
                }
                saveConfirmModal.show();
            });
            
            document.getElementById('confirmSaveBtn').addEventListener('click', function() {
                const form = document.getElementById('adminForm');
                const formData = new FormData(form);
                const action = formData.get('id') ? 'edit_admin' : 'add_admin';
                formData.append('action', action);
                
                saveConfirmModal.hide();
                submitForm(action, formData);
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                const adminId = this.dataset.id;
                const formData = new FormData();
                formData.append('action', 'delete_admin');
                formData.append('id', adminId);
                submitForm('delete_admin', formData);
            });

            document.getElementById('searchInput').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const filtered = allAdminAccounts.filter(admin => 
                    `${admin.firstName} ${admin.lastName}`.toLowerCase().includes(searchTerm) || 
                    admin.email.toLowerCase().includes(searchTerm)
                );
                renderAdminAccounts(filtered);
            });
            
            renderAdminAccounts(allAdminAccounts);
            setInterval(fetchAdminStatuses, 5000);
        });
    </script>
    <?php endif; ?>
</body>
</html>

