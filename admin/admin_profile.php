<?php
// Page-specific data
$page_title = "RAIS Admin - Admin Profile Management";
$active_page = "admin_profile";

// In a real application, this initial data would be fetched from your database.
$initialAdminAccounts = [
    [
        "id" => 1,
        "firstName" => "Super",
        "lastName" => "Admin",
        "email" => "admin@rais.com",
        "password" => "password",
        "profileImage" => "https://placehold.co/100x100/004d40/FFFFFF?text=SA",
        "type" => "Super Admin",
        "status" => "Active"
    ]
];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img/logoulit.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-table-image { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; }
        
        /* CHANGE 1: ADDED CSS TO FIX IMAGE OVERLAP IN MODAL */
        .admin-profile-image-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #dee2e6;
        }

        #passwordStrengthMeter { transition: width 0.3s ease-in-out; }
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
                            <input type="text" class="form-control" placeholder="Search by ID, name, or email..." id="searchInput">
                            <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th></th><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Type</th><th>Status</th><th>Password</th><th>Actions</th>
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
                        <input type="hidden" id="adminId">
                        <div class="mb-3 text-center">
                            <img id="adminImagePreview" src="https://placehold.co/120" alt="Admin Profile Preview" class="admin-profile-image-preview">
                            <input class="form-control mt-2" type="file" id="adminImageUpload" accept="image/*">
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="removeAdminImageBtn" style="color: var(--rais-primary-green); border-color: var(--rais-primary-green);">Remove Image</button>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="adminFirstName" class="form-label">First Name</label><input type="text" class="form-control" id="adminFirstName" required></div>
                            <div class="col-md-6 mb-3"><label for="adminLastName" class="form-label">Last Name</label><input type="text" class="form-control" id="adminLastName" required></div>
                        </div>
                        <div class="mb-3"><label for="adminEmail" class="form-label">Email Address</label><input type="email" class="form-control" id="adminEmail" required></div>
                        <div class="mb-3"><label for="adminType" class="form-label">Admin Type</label><select class="form-select" id="adminType"><option value="Admin">Admin</option><option value="Support Admin">Support Admin</option><option value="Finance Admin">Finance Admin</option><option value="Super Admin">Super Admin</option></select></div>
                        <div class="mb-3">
                            <label for="adminPassword" class="form-label">Password</label>
                            <!-- REMOVED 'pattern' to allow for custom JS validation messages -->
                            <input type="password" class="form-control" id="adminPassword" minlength="8" maxlength="20">
                            <small class="form-text text-muted" id="passwordHint">8-20 characters, with numbers & symbols (!@#$%). Leave blank if not changing.</small>
                            <div class="mt-2" id="passwordStrengthContainer" style="display: none;">
                                <div class="progress" style="height: 5px;">
                                    <div id="passwordStrengthMeter" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small id="passwordStrengthText"></small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="adminForm" class="btn btn-primary" style="background-color: var(--rais-button-maroon);">Save Admin</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Modals (Success, Error, Confirmation) -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="successModalLabel">Success</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="successModalBody"></div><div class="modal-footer"><button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="background-color: var(--rais-button-maroon);">OK</button></div></div></div></div>
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header bg-warning"><h5 class="modal-title" id="errorModalLabel">Warning</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="errorModalBody"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div></div></div></div>
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="deleteConfirmModalBody"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button></div></div></div></div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="togglemodeScript.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const initialAdminData = <?php echo json_encode($initialAdminAccounts, JSON_PRETTY_PRINT); ?>;
            const ADMIN_STORAGE_KEY = 'raisAdminAccounts';

            // --- ELEMENTS ---
            const adminModal = new bootstrap.Modal(document.getElementById('adminModal'));
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            
            const successModalBody = document.getElementById('successModalBody');
            const errorModalBody = document.getElementById('errorModalBody');
            const deleteConfirmModalBody = document.getElementById('deleteConfirmModalBody');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const adminAccountsTableBody = document.getElementById('adminAccountsTableBody');
            const addNewAdminBtn = document.getElementById('addNewAdminBtn');
            const adminForm = document.getElementById('adminForm');
            const adminIdInput = document.getElementById('adminId');
            const adminFirstNameInput = document.getElementById('adminFirstName');
            const adminLastNameInput = document.getElementById('adminLastName');
            const adminEmailInput = document.getElementById('adminEmail');
            const adminTypeInput = document.getElementById('adminType');
            const adminPasswordInput = document.getElementById('adminPassword');
            const passwordHint = document.getElementById('passwordHint');
            const adminImagePreview = document.getElementById('adminImagePreview');
            const adminImageUpload = document.getElementById('adminImageUpload');
            const removeAdminImageBtn = document.getElementById('removeAdminImageBtn');
            const searchInput = document.getElementById('searchInput');
            const strengthContainer = document.getElementById('passwordStrengthContainer');
            const strengthMeter = document.getElementById('passwordStrengthMeter');
            const strengthText = document.getElementById('passwordStrengthText');

            let adminAccounts = [];

            // --- FUNCTIONS ---
            function loadAdminAccounts() {
                const storedAdmins = localStorage.getItem(ADMIN_STORAGE_KEY);
                let loadedAccounts = [];
                try { loadedAccounts = storedAdmins ? JSON.parse(storedAdmins) : []; } catch (e) { loadedAccounts = []; }
                if (loadedAccounts.length === 0) {
                    adminAccounts = initialAdminData;
                    saveAdminAccounts();
                } else {
                    adminAccounts = loadedAccounts;
                }
            }

            function saveAdminAccounts() {
                localStorage.setItem(ADMIN_STORAGE_KEY, JSON.stringify(adminAccounts));
                renderAdminAccounts();
            }

            function renderAdminAccounts(filteredData = adminAccounts) {
                adminAccountsTableBody.innerHTML = '';
                filteredData.forEach(admin => {
                    const row = adminAccountsTableBody.insertRow();
                    const statusBadge = admin.status === 'Active' ? 'bg-success' : 'bg-danger';
                    const profileImageSrc = admin.profileImage || 'https://placehold.co/40x40/E8E8E8/000000?text=NA';
                    row.innerHTML = `<td><img src="${profileImageSrc}" class="admin-table-image"></td><td>${admin.id}</td><td>${admin.firstName}</td><td>${admin.lastName}</td><td>${admin.email}</td><td>${admin.type}</td><td><span class="badge ${statusBadge}">${admin.status}</span></td><td><span class="password-text">${'*'.repeat((admin.password || '').length)}</span> <button class="btn btn-sm btn-outline-secondary show-password-btn">Show</button></td><td><button class="btn btn-sm btn-info me-1 edit-admin-btn" style="background-color: var(--rais-primary-green); color: white;" data-admin-id="${admin.id}">Edit</button><button class="btn btn-sm btn-danger delete-admin-btn" data-admin-id="${admin.id}" data-admin-name="${admin.firstName} ${admin.lastName}">Delete</button></td>`;
                });
                document.querySelectorAll('.edit-admin-btn').forEach(button => button.addEventListener('click', (e) => editAdminUser(e.target.dataset.adminId)));
                document.querySelectorAll('.delete-admin-btn').forEach(button => button.addEventListener('click', (e) => promptToDeleteAdmin(e.currentTarget)));
                document.querySelectorAll('.show-password-btn').forEach(button => button.addEventListener('click', handleShowPassword));
            }
            
            function showAdminForm(adminData = null) {
                adminForm.reset();
                adminForm.classList.remove('was-validated');
                updatePasswordStrength('');
                strengthContainer.style.display = 'none';
                
                adminIdInput.value = '';
                adminImagePreview.src = 'https://placehold.co/120';
                adminPasswordInput.removeAttribute('required');
                passwordHint.style.display = 'block';

                if (adminData) {
                    document.getElementById('adminModalLabel').textContent = `Edit Admin: ${adminData.firstName} ${adminData.lastName}`;
                    adminIdInput.value = adminData.id;
                    adminFirstNameInput.value = adminData.firstName;
                    adminLastNameInput.value = adminData.lastName;
                    adminEmailInput.value = adminData.email;
                    adminTypeInput.value = adminData.type;
                    adminImagePreview.src = adminData.profileImage || 'https://placehold.co/120';
                    adminPasswordInput.placeholder = 'Leave blank to keep current';
                } else {
                    document.getElementById('adminModalLabel').textContent = 'Add New Admin';
                    adminPasswordInput.placeholder = 'Enter password';
                    adminPasswordInput.setAttribute('required', 'true');
                    passwordHint.style.display = 'block';
                }
                adminModal.show();
            }
            
            // CHANGE 2: ADDED SPECIFIC PASSWORD VALIDATION AND ERROR MESSAGES
            function saveAdminUser(event) {
                event.preventDefault();
                const id = adminIdInput.value;
                const password = adminPasswordInput.value;

                // --- Start Custom Password Validation ---
                if (id && !password) {
                    // Editing user and not changing password, so skip password validation
                    adminPasswordInput.removeAttribute('required');
                } else {
                    // New user or changing password, so validate it
                    adminPasswordInput.setAttribute('required', 'true');
                    
                    if (password.length < 8 || password.length > 20) {
                        errorModalBody.textContent = 'Password must be between 8 and 20 characters.';
                        errorModal.show();
                        return;
                    }
                    if (!/[0-9]/.test(password)) {
                        errorModalBody.textContent = 'Password must contain at least one number.';
                        errorModal.show();
                        return;
                    }
                    if (!/[!@#$%^&*]/.test(password)) {
                        errorModalBody.textContent = 'Password must contain at least one special symbol (e.g., !@#$%).';
                        errorModal.show();
                        return;
                    }
                }
                // --- End Custom Password Validation ---

                if (!adminForm.checkValidity()) {
                    event.stopPropagation();
                    adminForm.classList.add('was-validated');
                    return;
                }

                const adminData = { firstName: adminFirstNameInput.value, lastName: adminLastNameInput.value, email: adminEmailInput.value, type: adminTypeInput.value, profileImage: adminImagePreview.src };
                const adminFullName = `${adminData.firstName} ${adminData.lastName}`;

                if (id) {
                    const adminIndex = adminAccounts.findIndex(admin => admin.id == id);
                    adminAccounts[adminIndex] = { ...adminAccounts[adminIndex], ...adminData };
                    if (password) adminAccounts[adminIndex].password = password;
                } else {
                    const maxId = adminAccounts.length > 0 ? Math.max(...adminAccounts.map(admin => admin.id)) : 0;
                    adminAccounts.push({ id: maxId + 1, ...adminData, password, status: 'Active' });
                }
                
                saveAdminAccounts();
                adminModal.hide();
                successModalBody.textContent = `Admin account for ${adminFullName} has been saved successfully!`;
                successModal.show();
            }

            function editAdminUser(id) { const adminData = adminAccounts.find(admin => admin.id == id); if (adminData) showAdminForm(adminData); }

            function promptToDeleteAdmin(button) {
                const adminId = button.dataset.adminId;
                const adminName = button.dataset.adminName;
                if (adminAccounts.length <= 1) {
                    errorModalBody.textContent = 'You cannot delete the last remaining admin account.';
                    errorModal.show();
                    return;
                }
                deleteConfirmModalBody.textContent = `Are you sure you want to delete the admin account for ${adminName}?`;
                confirmDeleteBtn.dataset.adminIdToDelete = adminId;
                deleteConfirmModal.show();
            }

            function performDelete() {
                const id = confirmDeleteBtn.dataset.adminIdToDelete;
                adminAccounts = adminAccounts.filter(admin => admin.id != id);
                saveAdminAccounts();
                deleteConfirmModal.hide();
                successModalBody.textContent = 'Admin account has been deleted successfully.';
                successModal.show();

            }

            function updatePasswordStrength(password) {
                let score = 0;
                if (!password) { strengthContainer.style.display = 'none'; return; }
                strengthContainer.style.display = 'block';
                if (password.length >= 8) score++;
                if (password.length > 12) score++;
                if (/[A-Z]/.test(password)) score++;
                if (/[0-9]/.test(password)) score++;
                if (/[!@#$%^&*]/.test(password)) score++;
                
                let width = (score / 5) * 100;
                let colorClass = 'bg-danger';
                let text = 'Weak';
                if (score > 2) { colorClass = 'bg-warning'; text = 'Medium'; }
                if (score > 4) { colorClass = 'bg-success'; text = 'Strong'; }

                strengthMeter.style.width = `${width}%`;
                strengthMeter.className = `progress-bar ${colorClass}`;
                strengthText.textContent = text;
            }
            
            function handleShowPassword(e) { const button = e.target; const passwordSpan = button.previousElementSibling; const adminId = button.closest('tr').querySelector('.edit-admin-btn').dataset.adminId; const actualPassword = adminAccounts.find(a => a.id == adminId).password; if (passwordSpan.textContent.includes('*')) { passwordSpan.textContent = actualPassword; button.textContent = 'Hide'; } else { passwordSpan.textContent = '*'.repeat(actualPassword.length); button.textContent = 'Show'; } }
            function handleImageUpload(event) { const file = event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = e => adminImagePreview.src = e.target.result; reader.readAsDataURL(file); } }
            function removeAdminImage() { adminImagePreview.src = 'https://placehold.co/120'; adminImageUpload.value = ''; }

            // --- EVENT LISTENERS ---
            addNewAdminBtn.addEventListener('click', () => showAdminForm());
            adminForm.addEventListener('submit', saveAdminUser);
            confirmDeleteBtn.addEventListener('click', performDelete);
            adminImageUpload.addEventListener('change', handleImageUpload);
            removeAdminImageBtn.addEventListener('click', removeAdminImage);
            adminPasswordInput.addEventListener('keyup', (e) => updatePasswordStrength(e.target.value));
            searchInput.addEventListener('keyup', function() { const searchTerm = this.value.toLowerCase(); const filteredData = adminAccounts.filter(admin => String(admin.id).includes(searchTerm) || `${admin.firstName} ${admin.lastName}`.toLowerCase().includes(searchTerm) || admin.email.toLowerCase().includes(searchTerm)); renderAdminAccounts(filteredData); });

            // --- INITIAL LOAD ---
            loadAdminAccounts();
            renderAdminAccounts();
        });
    </script>
</body>
</html>