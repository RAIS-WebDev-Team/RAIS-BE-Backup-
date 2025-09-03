<?php
// Page-specific data
$page_title = "RAIS Admin - Application Management";
$active_page = "application_management";

// Include database connection
require_once '../config.php';

// --- FETCH CLIENT APPLICATIONS ---
$clientApplications = [];
$sql_clients = "SELECT id, fullName, email, phone, address, interestPathway, findUs, facebookLink, submission_date, status FROM client_applications ORDER BY submission_date DESC";
$result_clients = $conn->query($sql_clients);
if ($result_clients && $result_clients->num_rows > 0) {
    while ($row = $result_clients->fetch_assoc()) {
        $clientApplications[] = $row;
    }
}

// --- FETCH ALL USER DOCUMENTS ---
$pendingFiles = [];
$approvedFiles = [];
$cancelledFiles = [];

$sql_docs = "SELECT ud.id, ud.file_name, ud.file_path, ud.status, ud.upload_date, u.firstName, u.lastName 
        FROM user_documents ud 
        JOIN users u ON ud.user_id = u.id 
        ORDER BY ud.upload_date DESC";

if ($result_docs = $conn->query($sql_docs)) {
    while ($row = $result_docs->fetch_assoc()) {
        $fileData = $row;
        
        // Ensure file_path is consistent (remove ../ if it exists)
        if (strpos($fileData['file_path'], '../') === 0) {
            $fileData['file_path'] = substr($fileData['file_path'], 3);
        }

        $fileData['userName'] = $row['firstName'] . ' ' . $row['lastName'];

        // Infer file type for icon logic
        $extension = strtolower(pathinfo($row['file_name'], PATHINFO_EXTENSION));
        $inferred_file_type = 'application/octet-stream';
        $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        if (in_array($extension, $image_extensions)) $inferred_file_type = 'image/' . $extension;
        if ($extension === 'pdf') $inferred_file_type = 'application/pdf';
        if (in_array($extension, ['doc', 'docx'])) $inferred_file_type = 'application/msword';
        $fileData['file_type'] = $inferred_file_type;
        
        switch ($row['status']) {
            case 'approved':
                $approvedFiles[] = $fileData;
                break;
            case 'cancelled':
                $cancelledFiles[] = $fileData;
                break;
            case 'pending':
            default:
                $pendingFiles[] = $fileData;
                break;
        }
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
        .nav-tabs-custom .nav-link { border: none; border-bottom: 2px solid transparent; color: var(--rais-text-light); }
        .nav-tabs-custom .nav-link.active, .nav-tabs-custom .nav-item.show .nav-link { color: var(--rais-primary-green); border-bottom-color: var(--rais-primary-green); background-color: transparent; }
        .details-list-group .list-group-item { background-color: transparent; border-color: rgba(0,0,0,0.08); }
        .details-list-group strong { color: var(--rais-dark-blue); }
        body.dark-mode .modal-content { background-color: #2a2a35; color: #e1e1e1; border: 1px solid #444; }
        body.dark-mode .modal-header { border-bottom-color: #444; }
        body.dark-mode .modal-header .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        body.dark-mode .details-list-group .list-group-item { border-color: rgba(255, 255, 255, 0.15); color: #ffffff; }
        body.dark-mode .details-list-group strong { color: #ffffff; }
        body.dark-mode .details-list-group a { color: #96bfff; }
        body.dark-mode .details-list-group a:hover { color: #b9d5ff; }
        body.dark-mode .table { color: #e1e1e1; }
        body.dark-mode .table th, body.dark-mode .table td, body.dark-mode .table thead th { border-color: #444; }
        body.dark-mode .table-hover tbody tr:hover { background-color: rgba(255, 255, 255, 0.075); }
        body.dark-mode .table-hover tbody tr:hover td { color: #ffffff; }
        #previewModal .modal-body img { max-width: 100%; height: auto; display: block; margin: auto; }
        #previewModal .modal-body iframe { width: 100%; height: 75vh; border: none; }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <?php require_once 'sidebar.php'; ?>
        <div class="content-area">
            <?php require_once 'header.php'; ?>
            <main class="main-content">
                <h1>Application Management</h1>

                <div class="content-card mb-4" id="clientAppCard">
                    <h2 class="mb-3">Client Applications</h2>
                    <div class="table-responsive pt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="client-applications-tbody"></tbody>
                        </table>
                    </div>
                </div>

                <div class="content-card" id="documentManagementCard">
                    <h2 class="mb-3">Documents Management</h2>
                     <ul class="nav nav-tabs nav-tabs-custom mb-3">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pending-docs">Pending</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#approved-docs">Approved</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#cancelled-docs">Cancelled</button></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pending-docs"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>User Name</th><th>File Name</th><th>Submitted</th><th>Actions</th></tr></thead><tbody id="pending-tbody"></tbody></table></div></div>
                        <div class="tab-pane fade" id="approved-docs"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>User Name</th><th>File Name</th><th>Submitted</th><th>Actions</th></tr></thead><tbody id="approved-tbody"></tbody></table></div></div>
                        <div class="tab-pane fade" id="cancelled-docs"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>User Name</th><th>File Name</th><th>Submitted</th><th>Actions</th></tr></thead><tbody id="cancelled-tbody"></tbody></table></div></div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="detailsModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Application Details</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="detailsModalBody"></div></div></div></div>
    <div class="modal fade" id="previewModal" tabindex="-1"><div class="modal-dialog modal-xl modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="previewModalLabel">File Preview</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"></div></div></div></div>
    <div class="modal fade" id="actionConfirmModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="actionConfirmTitle"></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="actionConfirmText"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn" id="confirmActionBtn">Confirm</button></div></div></div></div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Client Applications Data & Logic ---
        const clientApplications = <?php echo json_encode($clientApplications); ?>;
        const detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
        
        function renderClientApplications() {
            const tbody = document.getElementById('client-applications-tbody');
            tbody.innerHTML = '';
            if (clientApplications.length === 0) {
                 tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No client applications found.</td></tr>`;
                 return;
            }
            clientApplications.forEach(app => {
                const row = document.createElement('tr');
                row.dataset.appId = app.id;
                row.innerHTML = `
                    <td>APP-${app.id}</td>
                    <td>${app.fullName}</td>
                    <td>${app.email}</td>
                    <td>${new Date(app.submission_date).toLocaleDateString()}</td>
                    <td><button class="btn btn-sm btn-outline-info details-btn" title="View Details"><i class="bi bi-person-lines-fill"></i> View Details</button></td>`;
                tbody.appendChild(row);
            });
        }
        
        function handleClientActionClick(event) {
            const button = event.target.closest('button.details-btn');
            if (!button) return;
            const appId = button.closest('tr').dataset.appId;
            const app = clientApplications.find(a => a.id == appId);
            if (!app) return;
            const detailsBody = document.getElementById('detailsModalBody');
            detailsBody.innerHTML = `<ul class="list-group details-list-group">
                    <li class="list-group-item"><strong>Name:</strong> ${app.fullName}</li>
                    <li class="list-group-item"><strong>Email:</strong> ${app.email}</li>
                    <li class="list-group-item"><strong>Phone Number:</strong> ${app.phone}</li>
                    <li class="list-group-item"><strong>Address:</strong> ${app.address}</li>
                    <li class="list-group-item"><strong>Interest Pathway:</strong> ${app.interestPathway}</li>
                    <li class="list-group-item"><strong>Found Us Via:</strong> ${app.findUs}</li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div><strong>Facebook Profile:</strong> <a href="${app.facebookLink}" target="_blank" title="${app.facebookLink}" class="text-decoration-none ms-2" style="word-break: break-all;">${app.facebookLink}</a></div>
                        <a href="${app.facebookLink}" target="_blank" title="View Facebook Profile"><i class="bi bi-facebook" style="font-size: 1.75rem; color: #0866FF;"></i></a>
                    </li>
                    <li class="list-group-item"><strong>Submitted On:</strong> ${new Date(app.submission_date).toLocaleString()}</li>
                </ul>`;
            detailsModal.show();
        }

        // --- Document Management Data & Logic ---
        const allFiles = {
            pending: <?php echo json_encode($pendingFiles); ?>,
            approved: <?php echo json_encode($approvedFiles); ?>,
            cancelled: <?php echo json_encode($cancelledFiles); ?>
        };
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        const actionConfirmModal = new bootstrap.Modal(document.getElementById('actionConfirmModal'));

        function renderDocumentTable(status) {
            const tbody = document.getElementById(`${status}-tbody`);
            tbody.innerHTML = '';
            const files = allFiles[status];
            if (files.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No documents in this category.</td></tr>`;
                return;
            }
            files.forEach(file => {
                const row = tbody.insertRow();
                row.innerHTML = `
                    <td>${file.userName}</td>
                    <td>${file.file_name}</td>
                    <td>${new Date(file.upload_date).toLocaleDateString()}</td>
                    <td>
                        <div class="d-flex gap-1">
                            ${status === 'pending' ? `<button class="btn btn-sm btn-success action-btn" data-action="approve" data-doc-id="${file.id}" title="Approve"><i class="bi bi-check-lg"></i></button>` : ''}
                            ${status !== 'cancelled' ? `<button class="btn btn-sm btn-warning action-btn" data-action="cancel" data-doc-id="${file.id}" title="Cancel"><i class="bi bi-x-lg"></i></button>` : ''}
                            <button class="btn btn-sm btn-info action-btn" data-action="preview" data-doc-path="${file.file_path}" data-doc-name="${file.file_name}" data-doc-type="${file.file_type}" title="Preview"><i class="bi bi-eye-fill"></i></button>
                            <a href="../${file.file_path}" class="btn btn-sm btn-secondary" download="${file.file_name}" title="Download"><i class="bi bi-download"></i></a>
                            <button class="btn btn-sm btn-danger action-btn" data-action="delete" data-doc-id="${file.id}" title="Delete"><i class="bi bi-trash-fill"></i></button>
                        </div>
                    </td>`;
            });
        }

        function handleDocumentActionClick(e) {
            const button = e.target.closest('.action-btn');
            if (!button) return;
            const action = button.dataset.action;
            const docId = button.dataset.docId;

            if (action === 'preview') {
                const filePath = `../${button.dataset.docPath}`;
                const fileName = button.dataset.docName;
                const fileType = button.dataset.docType;
                const modalBody = document.querySelector('#previewModal .modal-body');
                document.getElementById('previewModalLabel').textContent = fileName;

                if (fileType.startsWith('image/')) {
                    modalBody.innerHTML = `<img src="${filePath}" class="img-fluid" alt="Preview">`;
                } else if (fileType.includes('pdf')) {
                    modalBody.innerHTML = `<iframe src="${filePath}" frameborder="0"></iframe>`;
                } else if (fileType.includes('word')) {
                    const googleViewerUrl = `https://docs.google.com/gview?url=${new URL(filePath, window.location.href).href}&embedded=true`;
                    modalBody.innerHTML = `<iframe src="${googleViewerUrl}"></iframe>`;
                } else {
                    modalBody.innerHTML = `<p class="text-center p-5">No preview available for this file type.</p>`;
                }
                previewModal.show();
            } else {
                const confirmBtn = document.getElementById('confirmActionBtn');
                const title = document.getElementById('actionConfirmTitle');
                const text = document.getElementById('actionConfirmText');
                confirmBtn.dataset.action = action;
                confirmBtn.dataset.docId = docId;
                const actionText = action.charAt(0).toUpperCase() + action.slice(1);
                title.textContent = `Confirm ${actionText}`;
                text.textContent = `Are you sure you want to ${action} this document?`;
                confirmBtn.className = 'btn';
                if (action === 'approve') confirmBtn.classList.add('btn-success');
                else if (action === 'cancel') confirmBtn.classList.add('btn-warning');
                else if (action === 'delete') confirmBtn.classList.add('btn-danger');
                actionConfirmModal.show();
            }
        }
        
        document.getElementById('confirmActionBtn').addEventListener('click', function() {
            const action = this.dataset.action;
            const docId = this.dataset.docId;
            let newStatus = '';
            let actionType = 'update_status';

            if (action === 'approve') newStatus = 'Approved';
            if (action === 'cancel') newStatus = 'Cancelled';
            if (action === 'delete') actionType = 'delete_document';

            fetch('update_document_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: actionType, docId: docId, newStatus: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) { window.location.reload(); } 
                else { alert('Action failed: ' + data.message); }
            })
            .catch(err => console.error('Fetch error:', err));
            actionConfirmModal.hide();
        });

        // --- Event Listeners & Initial Renders ---
        document.getElementById('clientAppCard').addEventListener('click', handleClientActionClick);
        document.getElementById('documentManagementCard').addEventListener('click', handleDocumentActionClick);
        
        renderClientApplications();
        renderDocumentTable('pending');
        renderDocumentTable('approved');
        renderDocumentTable('cancelled');
    });
    </script>
</body>
</html>

