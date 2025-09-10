<?php
session_start();
require_once '../config.php';

// Security Check: Ensure user is logged in and is a Super Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'Super Admin') {
    header("Location: ../login.php");
    exit;
}

$page_title = "RAIS Admin - Admin Profile Management";
$active_page = "admin_profile";

// Fetch all admin accounts from the database
$adminAccounts = [];
$sql = "SELECT id, firstName, lastName, email, profileImage, role AS type, status FROM users WHERE role LIKE '%Admin%' ORDER BY id ASC";
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        // Format the image path to be correct relative to the admin folder
        if ($row['profileImage']) {
            $row['profileImage'] = '../' . $row['profileImage'];
        }
        $adminAccounts[] = $row;
    }
    $result->free();
} else {
    // Handle potential query error
    $adminAccounts = []; // Ensure it's an empty array on error
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
    </style>
</head>

<body>
    <div class="main-wrapper">
        <?php require_once 'sidebar.php'; ?>
        <div class="content-area">
            <?php require_once 'header.php'; ?>
            <main class="main-content">
                <h1>Admin Profile Management</h1>
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
            </main>
        </div>
    </div>

    <!-- Modals -->
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
                        <div class="mb-3"><label for="adminType">Type</label><select class="form-select" id="adminType" name="type"><option>Super Admin</option><option>Admin</option></select></div>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let allAdminAccounts = <?php echo json_encode($adminAccounts); ?>;
            const adminModal = new bootstrap.Modal(document.getElementById('adminModal'));
            const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

            function renderAdminAccounts(accounts) {
                const tableBody = document.getElementById('adminAccountsTableBody');
                tableBody.innerHTML = '';
                accounts.forEach(admin => {
                    const profileImageSrc = admin.profileImage || 'https://placehold.co/40x40/6c757d/FFFFFF?text=NA';
                    const row = `<tr data-admin-id="${admin.id}">
                        <td><img src="${profileImageSrc}" class="admin-table-image" onerror="this.src='https://placehold.co/40x40/6c757d/FFFFFF?text=NA'"></td>
                        <td>${admin.id}</td>
                        <td>${admin.firstName} ${admin.lastName}</td>
                        <td>${admin.email}</td>
                        <td>${admin.type}</td>
                        <td class="status-cell"><span class="badge bg-warning text-dark">Checking...</span></td>
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
                    const response = await fetch('get_admin_status.php');
                    const statuses = await response.json();
                    if (statuses.status === 'success') {
                        updateStatusOnUI(statuses.data);
                    }
                } catch (error) {
                    console.error('Error fetching admin statuses:', error);
                }
            }
            
            function updateStatusOnUI(statusData) {
                allAdminAccounts.forEach(admin => {
                    const adminRow = document.querySelector(`tr[data-admin-id='${admin.id}']`);
                    if (adminRow) {
                        const statusCell = adminRow.querySelector('.status-cell');
                        const adminStatus = statusData[admin.id];
                        let statusBadge;
                        if (adminStatus && adminStatus.is_online) {
                            statusBadge = `<span class="badge bg-success">Active</span>`;
                        } else {
                            statusBadge = `<span class="badge bg-secondary">Inactive</span>`;
                        }
                        statusCell.innerHTML = statusBadge;
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
                    const adminId = editButton.dataset.id;
                    openModalForEdit(adminId);
                }
                const deleteButton = e.target.closest('.delete-btn');
                if (deleteButton) {
                    const adminId = deleteButton.dataset.id;
                    const adminName = deleteButton.dataset.name;
                    promptForDelete(adminId, adminName);
                }
            });

            document.getElementById('adminImageUpload').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => document.getElementById('adminImagePreview').src = e.target.result;
                    reader.readAsDataURL(file);
                }
            });

            async function submitForm(action, formData) {
                try {
                    const response = await fetch('admin_profile_handler.php', {
                        method: 'POST',
                        body: formData
                    });
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
                const formData = new FormData(form);
                const action = formData.get('id') ? 'edit_admin' : 'add_admin';
                formData.append('action', action);
                if (action === 'add_admin' && !formData.get('password')) {
                    alert('Password is required for new admin accounts.');
                    return;
                }
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
                const filtered = allAdminAccounts.filter(admin => {
                    const fullName = `${admin.firstName} ${admin.lastName}`.toLowerCase();
                    return fullName.includes(searchTerm) || admin.email.toLowerCase().includes(searchTerm);
                });
                renderAdminAccounts(filtered);
            });
            
            renderAdminAccounts(allAdminAccounts);
            setInterval(fetchAdminStatuses, 5000); // Refresh statuses every 5 seconds
        });
    </script>
</body>
</html>

