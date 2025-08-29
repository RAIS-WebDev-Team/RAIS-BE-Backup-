<?php
// Page-specific data
$page_title = "RAIS Admin - Application Management";
$active_page = "application_management";

// Data for the first card: Client Applications (with examples in each category)
$clientApplications = [
    ['id' => 'APP-001', 'userName' => 'John Doe (Visa)', 'status' => 'Pending Review', 'fileUrl' => 'path/to/document1.pdf', 'date' => '2024-08-10'],
    ['id' => 'APP-002', 'userName' => 'Jane Smith (Work Permit)', 'status' => 'Approved', 'fileUrl' => 'path/to/image.jpg', 'date' => '2024-08-09'],
    ['id' => 'APP-003', 'userName' => 'Peter Jones (Study Permit)', 'status' => 'Cancelled', 'fileUrl' => 'path/to/document2.pdf', 'date' => '2024-08-08'],
    ['id' => 'APP-004', 'userName' => 'Alice Brown (Visa)', 'status' => 'Pending Review', 'fileUrl' => 'path/to/another_image.png', 'date' => '2024-08-07'],
];

// Data for the second card: Service Offered Applications (with examples in each category)
$serviceApplications = [
    ['id' => 'SVC-001', 'userName' => 'IELTS Review Package', 'status' => 'Pending Review', 'fileUrl' => 'path/to/service-doc1.pdf', 'date' => '2024-08-10'],
    ['id' => 'SVC-002', 'userName' => 'Consultation Package', 'status' => 'Approved', 'fileUrl' => 'path/to/service-img.png', 'date' => '2024-08-09'],
    ['id' => 'SVC-003', 'userName' => 'Express Entry Profile', 'status' => 'Cancelled', 'fileUrl' => 'path/to/service-doc2.pdf', 'date' => '2024-08-08'],
];
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
        .nav-tabs-custom .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            color: var(--rais-text-light);
        }
        .nav-tabs-custom .nav-link.active,
        .nav-tabs-custom .nav-item.show .nav-link {
            color: var(--rais-primary-green);
            border-bottom-color: var(--rais-primary-green);
            background-color: transparent;
        }
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
                    <ul class="nav nav-tabs nav-tabs-custom">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#client-pending-tab-pane">Pending</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#client-approved-tab-pane">Approved</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#client-cancelled-tab-pane">Cancelled</button></li>
                    </ul>
                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="client-pending-tab-pane">
                            <div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>User Name</th><th>Submitted</th><th>Actions</th></tr></thead><tbody id="client-pending-tbody"></tbody></table></div>
                        </div>
                        <div class="tab-pane fade" id="client-approved-tab-pane">
                            <div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>User Name</th><th>Submitted</th><th>Actions</th></tr></thead><tbody id="client-approved-tbody"></tbody></table></div>
                        </div>
                        <div class="tab-pane fade" id="client-cancelled-tab-pane">
                            <div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>User Name</th><th>Submitted</th><th>Actions</th></tr></thead><tbody id="client-cancelled-tbody"></tbody></table></div>
                        </div>
                    </div>
                </div>

                <div class="content-card" id="serviceAppCard">
                    <h2 class="mb-3">Service Offered Application</h2>
                    <ul class="nav nav-tabs nav-tabs-custom">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#service-pending-tab-pane">Pending</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#service-approved-tab-pane">Approved</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#service-cancelled-tab-pane">Cancelled</button></li>
                    </ul>
                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="service-pending-tab-pane">
                            <div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Service Name</th><th>Submitted</th><th>Actions</th></tr></thead><tbody id="service-pending-tbody"></tbody></table></div>
                        </div>
                        <div class="tab-pane fade" id="service-approved-tab-pane">
                            <div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Service Name</th><th>Submitted</th><th>Actions</th></tr></thead><tbody id="service-approved-tbody"></tbody></table></div>
                        </div>
                        <div class="tab-pane fade" id="service-cancelled-tab-pane">
                             <div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Service Name</th><th>Submitted</th><th>Actions</th></tr></thead><tbody id="service-cancelled-tbody"></tbody></table></div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modals (shared by both sections) -->
    <div class="modal fade" id="previewModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">File Preview</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body text-center" id="previewModalBody"></div></div></div></div>
    <div class="modal fade" id="approveModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Approve Application</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p>Review and confirm approval for:</p><ul class="list-group"><li class="list-group-item"><strong>Applicant:</strong> <span id="approveApplicantName"></span></li><li class="list-group-item"><strong>File:</strong> <a href="#" id="approveFileLink" target="_blank"></a></li></ul></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="confirmApproveBtn">Confirm Approval</button></div></div></div></div>
    <div class="modal fade" id="cancelModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Cancel Application</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="cancelModalBody"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-danger" id="confirmCancelBtn">Yes, Cancel</button></div></div></div></div>
    
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let clientApplications = <?php echo json_encode($clientApplications, JSON_PRETTY_PRINT); ?>;
        let serviceApplications = <?php echo json_encode($serviceApplications, JSON_PRETTY_PRINT); ?>;
        
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
        const cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));

        function renderApplications(cardId, data) {
            const cardElement = document.getElementById(cardId);
            const pendingTbody = cardElement.querySelector('[id$="-pending-tbody"]');
            const approvedTbody = cardElement.querySelector('[id$="-approved-tbody"]');
            const cancelledTbody = cardElement.querySelector('[id$="-cancelled-tbody"]');

            pendingTbody.innerHTML = '';
            approvedTbody.innerHTML = '';
            cancelledTbody.innerHTML = '';

            data.forEach(app => {
                const isPending = app.status === 'Pending Review';
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${app.id}</td>
                    <td>${app.userName}</td>
                    <td>${app.date}</td>
                    <td>
                        <a href="${app.fileUrl}" class="btn btn-sm btn-outline-dark" download title="Download"><i class="bi bi-download"></i></a>
                        <button class="btn btn-sm btn-outline-info preview-btn" data-app-id="${app.id}" title="Preview"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-success approve-btn" data-app-id="${app.id}" title="Approve" ${!isPending ? 'disabled' : ''}><i class="bi bi-check-lg"></i></button>
                        <button class="btn btn-sm btn-danger cancel-btn" data-app-id="${app.id}" title="Cancel" ${!isPending ? 'disabled' : ''}><i class="bi bi-x-lg"></i></button>
                    </td>
                `;

                if (app.status === 'Pending Review') pendingTbody.appendChild(row);
                else if (app.status === 'Approved') approvedTbody.appendChild(row);
                else if (app.status === 'Cancelled') cancelledTbody.appendChild(row);
            });
        }
        
        function handleActionClick(event) {
            const button = event.target.closest('button.preview-btn, button.approve-btn, button.cancel-btn');
            if (!button) return;

            const appId = button.dataset.appId;
            const app = clientApplications.find(a => a.id === appId) || serviceApplications.find(a => a.id === appId);
            if (!app) return;

            if (button.classList.contains('preview-btn')) {
                const previewBody = document.getElementById('previewModalBody');
                if ((app.fileUrl || '').match(/\.(jpeg|jpg|gif|png)$/)) {
                    previewBody.innerHTML = `<img src="${app.fileUrl}" class="img-fluid" alt="File Preview">`;
                } else {
                    previewBody.innerHTML = `<p>Cannot preview this file type.</p><p>File: <a href="${app.fileUrl}" target="_blank">${app.fileUrl}</a></p>`;
                }
                previewModal.show();
            } else if (button.classList.contains('approve-btn')) {
                document.getElementById('approveApplicantName').textContent = app.userName;
                const fileLink = document.getElementById('approveFileLink');
                fileLink.href = app.fileUrl;
                fileLink.textContent = app.fileUrl.split('/').pop();
                document.getElementById('confirmApproveBtn').dataset.appId = appId;
                approveModal.show();
            } else if (button.classList.contains('cancel-btn')) {
                document.getElementById('cancelModalBody').textContent = `Are you sure you want to cancel the application for ${app.userName}?`;
                document.getElementById('confirmCancelBtn').dataset.appId = appId;
                cancelModal.show();
            }
        }

        function updateApplicationStatus(appId, newStatus) {
            let clientApp = clientApplications.find(a => a.id === appId);
            let serviceApp = serviceApplications.find(a => a.id === appId);

            if (clientApp) {
                clientApp.status = newStatus;
                renderApplications('clientAppCard', clientApplications); // Re-render the client card
            } else if (serviceApp) {
                serviceApp.status = newStatus;
                renderApplications('serviceAppCard', serviceApplications); // Re-render the service card
            }
        }

        document.body.addEventListener('click', handleActionClick);

        document.getElementById('confirmApproveBtn').addEventListener('click', function() {
            updateApplicationStatus(this.dataset.appId, 'Approved');
            approveModal.hide();
        });

        document.getElementById('confirmCancelBtn').addEventListener('click', function() {
            updateApplicationStatus(this.dataset.appId, 'Cancelled');
            cancelModal.hide();
        });

        // Initial render for both sections
        renderApplications('clientAppCard', clientApplications);
        renderApplications('serviceAppCard', serviceApplications);
    });
    </script>
</body>
</html>