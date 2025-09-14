<?php
session_start();
// The config file now provides the $pdo object for the initial data fetch.
require_once '../config.php';

// Security Check: Ensure user is logged in and is an Admin
if (!isset($_SESSION['loggedin']) || strpos($_SESSION['role'], 'Admin') === false) {
    header("Location: ../login.php");
    exit;
}

// Page-specific data
$page_title = "RAIS Admin - Content Management";
$active_page = "content_management";

// --- REMOVED LOCALSTORAGE-BASED DATA ---
// All data will now be fetched from the database via JavaScript.
$servicesData = [];
$blogsData = [];
$partnersData = [];
$footerData = [
    ["id" => 1, "label" => "Email", "description" => "contact@rais.com", "type" => "static"],
    ["id" => 2, "label" => "Contacts", "description" => "+1 (123) 456-7890", "type" => "static"],
    ["id" => 3, "label" => "Location", "description" => "123 Immigration Ave, Suite 100, Capital City", "type" => "static"]
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img/logoulit.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <!-- Custom styles for CMS enhancements -->
    <style>
        .table-responsive .table tr.selected {
            background-color: #e9ecef;
            box-shadow: 0 0 0 2px #0d6efd;
        }
        #about-edit-nav .nav-link.active {
            background-color: #800000; /* Maroon color */
            color: #ffffff;
            border-color: #800000;
        }
        #about-edit-nav .nav-link { color: #333; }
        .service-card.selected, .blog-card.selected {
            box-shadow: 0 0 0 3px #800000;
            border-color: #800000;
        }
        .blog-section-card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-left: 5px solid #1E4620; /* Dark green accent */
            border-radius: 0.375rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* --- Dark Mode Styles for About Section --- */
        body.dark-mode #about .card {
            background-color: #2b3035;
            color: #f8f9fa;
            border-color: #495057;
        }
        body.dark-mode #about .form-control {
            background-color: #495057;
            color: #f8f9fa;
            border-color: #6c757d;
        }
        body.dark-mode #about .form-control::placeholder {
            color: #adb5bd;
        }
        body.dark-mode #about h5.card-title,
        body.dark-mode #about .form-label,
        body.dark-mode #about p.text-muted,
        body.dark-mode #about .card-text,
        body.dark-mode #about h6.text-muted {
            color: #f8f9fa !important;
        }
        body.dark-mode #about-edit-nav .nav-link {
            color: #f8f9fa;
            border-color: #495057;
        }
        body.dark-mode #about-edit-nav .nav-link.active {
            background-color: #800000;
            color: #ffffff;
            border-color: #800000;
        }
        body.dark-mode #about .btn-outline-primary {
            color: #f8f9fa;
            border-color: #0d6efd;
        }
        body.dark-mode #about .btn-outline-primary:hover {
            background-color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <?php require_once 'sidebar.php'; ?>
        <div class="content-area">
            <?php require_once 'header.php'; ?>
            <main class="main-content">
                <h1>Content Management</h1>
                <div class="content-card">
                    <!-- Navigations -->
                    <div class="dropdown d-sm-none mb-3 content-nav">
                        <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" id="contentNavDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                        <ul class="dropdown-menu w-100" aria-labelledby="contentNavDropdown">
                            <li><a class="dropdown-item nav-link active" href="#" data-target="landing-page">Landing Page</a></li>
                            <li><a class="dropdown-item nav-link" href="#" data-target="about">About</a></li>
                            <li><a class="dropdown-item nav-link" href="#" data-target="services">Services</a></li>
                            <li><a class="dropdown-item nav-link" href="#" data-target="blogs">Blogs</a></li>
                            <li><a class="dropdown-item nav-link" href="#" data-target="partners">Partners</a></li>
                            <li><a class="dropdown-item nav-link" href="#" data-target="footer">Footer</a></li>
                        </ul>
                    </div>
                    <nav class="nav nav-pills flex-sm-row content-nav d-none d-sm-flex">
                        <a class="flex-sm-fill text-sm-center nav-link active" href="#" data-target="landing-page">Landing Page</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="#" data-target="about">About</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="#" data-target="services">Services</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="#" data-target="blogs">Blogs</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="#" data-target="partners">Partners</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="#" data-target="footer">Footer</a>
                    </nav>
                    <div id="content-sections">
                        <!-- Landing Page Section -->
                        <div id="landing-page" class="content-section active">
                            <div class="d-flex justify-content-between align-items-center mb-3"><h3>Edit Landing Page Hero Section</h3></div>
                            <p>Manage the videos available for your website's landing page. Select a video to manage it or set it as the active one.</p>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Status</th>
                                            <th scope="col">Media Name</th>
                                            <th scope="col">Uploader</th>
                                            <th scope="col">Date Uploaded</th>
                                            <th scope="col">File Path</th>
                                        </tr>
                                    </thead>
                                    <tbody id="media-table-body">
                                        <!-- Rows will be dynamically inserted here by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="fab-container">
                                <button id="set-active-landing-btn" class="btn btn-success btn-lg rounded-circle" title="Set as Active Video" disabled><i class="bi bi-check-circle-fill"></i></button>
                                <button id="preview-landing-btn" class="btn btn-info btn-lg rounded-circle" title="Preview Media" disabled><i class="bi bi-eye-fill"></i></button>
                                <button id="edit-landing-btn" class="btn btn-warning btn-lg rounded-circle" title="Edit Media" disabled><i class="bi bi-pencil-fill"></i></button>
                                <button id="delete-landing-btn" class="btn btn-danger btn-lg rounded-circle" title="Delete Media" disabled><i class="bi bi-trash-fill"></i></button>
                                <button id="add-landing-btn" class="btn btn-primary btn-lg rounded-circle" title="Add New Media"><i class="bi bi-plus-lg"></i></button>
                            </div>
                        </div>
                        <!-- About Section -->
                        <div id="about" class="content-section">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3>Edit About Page</h3>
                            </div>
                            <p class="text-muted small">Manage all content for the "About" section of your homepage.</p>
                            <nav class="nav nav-tabs mb-3" id="about-edit-nav">
                                <a class="nav-link active" href="#" data-target="about-main-section">Main Section</a>
                                <a class="nav-link" href="#" data-target="about-content-blocks">"Learn More" Paragraphs</a>
                                <a class="nav-link" href="#" data-target="about-cards-section">"Learn More" Tabs (Mission/Vision)</a>
                            </nav>
                            <div id="about-main-section" class="about-edit-pane active"><div class="card"><div class="card-body"><h5 class="card-title">Main Media, Title, and Description</h5><form id="about-main-form"><input type="hidden" id="clear-media-flag" name="clear_media" value="0"><div class="mb-3"><label for="about-hero-file" class="form-label">Hero Media (Photo or Video)</label><div class="input-group"><input type="file" class="form-control" id="about-hero-file" name="mediaFile" accept="image/*,video/*"><button class="btn btn-outline-danger" type="button" id="clear-hero-media-btn" title="Clear Media"><i class="bi bi-x-lg"></i></button></div><div id="about-hero-preview" class="mt-2 border rounded p-2" style="min-height: 100px;"></div></div><div class="mb-3"><label for="about-hero-title" class="form-label">Main Title</label><input type="text" class="form-control" id="about-hero-title" name="title"></div><div class="mb-3"><label for="about-hero-description" class="form-label">Main Description</label><textarea class="form-control" id="about-hero-description" name="description" rows="4"></textarea></div></form></div></div></div>
                            <div id="about-content-blocks" class="about-edit-pane" style="display: none;"><div class="card"><div class="card-body"><h5 class="card-title">"Learn More" Paragraphs</h5><p class="card-text text-muted">These paragraphs appear at the top of the expanded "Learn More" section.</p><div id="about-content-blocks-container"></div><hr><button class="btn btn-outline-primary" id="add-text-block-btn"><i class="bi bi-body-text me-2"></i>Add Text Paragraph</button></div></div></div>
                            <div id="about-cards-section" class="about-edit-pane" style="display: none;"><div class="card"><div class="card-body"><h5 class="card-title">"Learn More" Tabs (Mission, Vision, etc.)</h5><p class="card-text text-muted">These items will appear in the tabbed interface at the bottom of the "Learn More" section.</p><div id="about-cards-container"></div><hr><button class="btn btn-outline-primary" id="add-about-card-btn"><i class="bi bi-plus-square me-2"></i>Add New Card</button></div></div></div>
                             <div class="fab-container" style="display: none;">
                                <button id="cancel-about-changes-btn" class="btn btn-secondary btn-lg rounded-circle" title="Reload and discard changes"><i class="bi bi-arrow-counterclockwise"></i></button>
                                <button id="save-all-about-changes-btn" class="btn btn-success btn-lg rounded-circle" title="Save All Changes"><i class="bi bi-check-lg"></i></button>
                            </div>
                        </div>
                        <!-- Other sections omitted for brevity -->
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- ALL MODALS AND TEMPLATES -->
    <div class="modal fade" id="uploadMediaModal" tabindex="-1" data-bs-backdrop="static"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="uploadMediaModalLabel">Add New Hero Media</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><form id="upload-form" novalidate><input type="hidden" id="mediaId" name="id" value=""><div class="mb-3"><label for="mediaName" class="form-label">Media Name</label><input type="text" class="form-control" id="mediaName" name="mediaName" required></div><div class="mb-3"><label for="uploaderName" class="form-label">Uploader</label><input type="text" class="form-control" id="uploaderName" name="uploaderName" value="<?php echo htmlspecialchars($_SESSION['firstName'] . ' ' . $_SESSION['lastName']); ?>" required></div><div class="mb-3"><label for="mediaFile" class="form-label">Upload Video</label><input class="form-control" type="file" id="mediaFile" name="mediaFile" accept="video/*" required><div class="form-text" id="mediaFileHelp">Select a new video file to upload.</div></div></form></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="save-media-btn">Save Media</button></div></div></div></div>
    <div class="modal fade" id="landing-confirmation-modal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="landing-confirmation-title">Confirm Action</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="landing-confirmation-body"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="confirm-landing-action-btn">Confirm</button></div></div></div></div>
    <div class="modal fade" id="landing-preview-modal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="landing-preview-title">Media Preview</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="landing-preview-body" class="text-center"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div></div></div></div>
    
    <template id="about-text-block-template"><div class="p-3 border rounded mb-3 dynamic-about-block" data-type="text"><div class="d-flex justify-content-between align-items-center mb-2"><h6 class="mb-0 text-muted">Text Paragraph</h6><button type="button" class="btn-close remove-about-block-btn"></button></div><textarea class="form-control block-content" rows="5" placeholder="Enter paragraph text here..."></textarea></div></template>
    <template id="about-card-template"><div class="p-3 border rounded mb-3 dynamic-about-card"><div class="d-flex justify-content-between align-items-center mb-2"><h6 class="mb-0 text-muted">Tabbed Card</h6><button type="button" class="btn-close remove-about-card-btn"></button></div><div class="row"><div class="col-md-6 mb-2"><label class="form-label small">Tab Title</label><input type="text" class="form-control card-tab-title" placeholder="e.g., Mission"></div><div class="col-md-6 mb-2"><label class="form-label small">Card Title</label><input type="text" class="form-control card-title" placeholder="e.g., Mission Statement"></div></div><div class="mb-2"><label class="form-label small">Card Content</label><textarea class="form-control card-content" rows="4"></textarea></div></div></template>
    <!-- Other Modals & Templates omitted for brevity -->
    
    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="togglemodeScript.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- DATA INJECTION FROM PHP (used only for initial non-localStorage data) ---
        let initialBlogsData = <?php echo json_encode($blogsData, JSON_PRETTY_PRINT); ?>;
        let initialPartnersData = <?php echo json_encode($partnersData, JSON_PRETTY_PRINT); ?>;
        let footerData = <?php echo json_encode($footerData, JSON_PRETTY_PRINT); ?>;
        // --- MAIN NAVIGATION LOGIC ---
        const navLinks = document.querySelectorAll('.content-nav .nav-link');
        const contentSections = document.querySelectorAll('.content-section');
        const dropdownButton = document.getElementById('contentNavDropdown');
        function setActiveNav(targetId) { 
            const activeLink = document.querySelector(`.content-nav .nav-link[data-target="${targetId}"]`); 
            if (!activeLink) return; 
            if (dropdownButton) { dropdownButton.textContent = activeLink.textContent; } 
            navLinks.forEach(link => { link.classList.toggle('active', link.getAttribute('data-target') === targetId); }); 
            contentSections.forEach(section => { section.classList.toggle('active', section.id === targetId); }); 
            updateFabVisibility(); // Call this to update FABs on nav change
        }
        navLinks.forEach(link => { link.addEventListener('click', function(e) { e.preventDefault(); const targetId = this.getAttribute('data-target'); setActiveNav(targetId); }); });
        (function handleDeepLink() { const hash = window.location.hash; const targetId = hash ? hash.substring(1) : null; const initialActiveLink = document.querySelector('.content-nav .nav-link.active'); if (targetId) { setActiveNav(targetId); } else if (initialActiveLink) { setActiveNav(initialActiveLink.getAttribute('data-target')); } })();
        
        const confirmationModalEl = document.getElementById('landing-confirmation-modal');
        const confirmationModal = new bootstrap.Modal(confirmationModalEl);
        const confirmationModalBody = document.getElementById('landing-confirmation-body');
        const confirmActionBtn = document.getElementById('confirm-landing-action-btn');
        const confirmationModalTitle = document.getElementById('landing-confirmation-title');
        
        // --- START: SCRIPT FOR LANDING PAGE MANAGEMENT ---
        (function() {
            let landingMediaData = [];
            let selectedMediaId = null;
            const mediaTableBody = document.getElementById('media-table-body');
            const addLandingBtn = document.getElementById('add-landing-btn');
            const editLandingBtn = document.getElementById('edit-landing-btn');
            const deleteLandingBtn = document.getElementById('delete-landing-btn');
            const previewLandingBtn = document.getElementById('preview-landing-btn');
            const setActiveLandingBtn = document.getElementById('set-active-landing-btn');
            const uploadModal = new bootstrap.Modal(document.getElementById('uploadMediaModal'));
            const previewModal = new bootstrap.Modal(document.getElementById('landing-preview-modal'));
            const uploadForm = document.getElementById('upload-form');
            const saveMediaBtn = document.getElementById('save-media-btn');
            
            async function loadAndRenderMedia() {
                try {
                    const response = await fetch('api_landing_media.php?action=fetch');
                    const result = await response.json();
                    if (result.success) {
                        landingMediaData = result.data;
                        renderTable();
                    } else {
                        alert('Error fetching media: ' + result.message);
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    alert('A network error occurred. Please try again.');
                }
            }
            function renderTable() {
                mediaTableBody.innerHTML = '';
                if (landingMediaData.length === 0) {
                    mediaTableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No media has been uploaded yet.</td></tr>';
                    return;
                }
                landingMediaData.forEach(media => {
                    const row = mediaTableBody.insertRow();
                    row.dataset.id = media.id;
                    row.dataset.filePath = media.file_path;
                    row.dataset.isActive = media.is_active;
                    const statusCell = row.insertCell();
                    if (media.is_active == 1) {
                        statusCell.innerHTML = '<span class="badge bg-success">Active</span>';
                    }
                    row.insertCell().textContent = media.media_name;
                    row.insertCell().textContent = media.uploader;
                    row.insertCell().textContent = new Date(media.upload_date).toLocaleDateString();
                    row.insertCell().textContent = media.file_path;
                    if (parseInt(media.id) === selectedMediaId) {
                        row.classList.add('selected');
                    }
                });
            }
            function updateFabState() {
                const isSelected = selectedMediaId !== null;
                editLandingBtn.disabled = !isSelected;
                deleteLandingBtn.disabled = !isSelected;
                previewLandingBtn.disabled = !isSelected;
                const selectedItem = landingMediaData.find(m => m.id == selectedMediaId);
                setActiveLandingBtn.disabled = !isSelected || (selectedItem && selectedItem.is_active == 1);
            }
            function selectRow(mediaId) {
                selectedMediaId = (selectedMediaId === mediaId) ? null : mediaId;
                renderTable();
                updateFabState();
            }
            function resetAndPrepareModal(mode = 'add', media = null) {
                uploadForm.reset();
                uploadForm.classList.remove('was-validated');
                const modalTitle = document.getElementById('uploadMediaModalLabel');
                const mediaFileInput = document.getElementById('mediaFile');
                const mediaFileHelp = document.getElementById('mediaFileHelp');
                document.getElementById('mediaId').value = '';
                if (mode === 'add') {
                    modalTitle.textContent = 'Add New Hero Media';
                    saveMediaBtn.textContent = 'Add Media';
                    saveMediaBtn.dataset.mode = 'add';
                    mediaFileInput.required = true;
                    mediaFileHelp.textContent = 'Please select a video to upload.';
                } else if (mode === 'edit' && media) {
                    modalTitle.textContent = `Edit Media: ${media.media_name}`;
                    saveMediaBtn.textContent = 'Update Media';
                    saveMediaBtn.dataset.mode = 'edit';
                    document.getElementById('mediaId').value = media.id;
                    document.getElementById('mediaName').value = media.media_name;
                    document.getElementById('uploaderName').value = media.uploader;
                    mediaFileInput.required = false;
                    mediaFileHelp.textContent = `Current file: ${media.file_path}. Uploading a new file will replace it.`;
                }
            }
            mediaTableBody.addEventListener('click', e => {
                const row = e.target.closest('tr');
                if (row && row.dataset.id) {
                    selectRow(parseInt(row.dataset.id));
                }
            });
            addLandingBtn.addEventListener('click', () => {
                resetAndPrepareModal('add');
                uploadModal.show();
            });
            editLandingBtn.addEventListener('click', () => {
                if (selectedMediaId === null) return;
                const media = landingMediaData.find(m => m.id == selectedMediaId);
                resetAndPrepareModal('edit', media);
                uploadModal.show();
            });
            saveMediaBtn.addEventListener('click', async () => {
                if (!uploadForm.checkValidity()) {
                    uploadForm.reportValidity();
                    return;
                }
                const formData = new FormData(uploadForm);
                const mode = saveMediaBtn.dataset.mode;
                formData.append('action', mode);
                try {
                    const response = await fetch('api_landing_media.php', {
                        method: 'POST',
                        body: formData
                    });
                    const resultText = await response.text();
                    try {
                        const result = JSON.parse(resultText);
                        if (result.success) {
                            uploadModal.hide();
                            loadAndRenderMedia();
                        } else {
                            alert('Error: ' + result.message);
                        }
                    } catch (e) {
                        console.error('Failed to parse JSON:', resultText);
                        alert('An unexpected server error occurred. The server responded with:\n\n' + resultText);
                    }
                } catch (error) {
                    console.error('Save error:', error);
                    alert('A network error occurred while saving.');
                }
            });
            deleteLandingBtn.addEventListener('click', () => {
                if (selectedMediaId === null) return;
                const media = landingMediaData.find(m => m.id == selectedMediaId);
                confirmationModalTitle.textContent = "Confirm Deletion";
                confirmationModalBody.innerHTML = `Are you sure you want to delete the media: <strong>${media.media_name}</strong>? This cannot be undone.`;
                confirmActionBtn.onclick = async () => {
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id', selectedMediaId);
                    const response = await fetch('api_landing_media.php', { method: 'POST', body: formData });
                    const result = await response.json();
                    if (result.success) {
                        selectedMediaId = null;
                        loadAndRenderMedia();
                    } else { alert('Error: ' + result.message); }
                    confirmationModal.hide();
                };
                confirmationModal.show();
            });
            previewLandingBtn.addEventListener('click', () => {
                if (selectedMediaId === null) return;
                const media = landingMediaData.find(m => m.id == selectedMediaId);
                document.getElementById('landing-preview-title').textContent = `Preview: ${media.media_name}`;
                const previewBody = document.getElementById('landing-preview-body');
                const previewPath = '../' + media.file_path;
                previewBody.innerHTML = `<video src="${previewPath}" class="img-fluid rounded" controls autoplay muted loop></video>`;
                previewModal.show();
            });
            setActiveLandingBtn.addEventListener('click', () => {
                if (selectedMediaId === null) return;
                const media = landingMediaData.find(m => m.id == selectedMediaId);
                confirmationModalTitle.textContent = "Confirm New Active Video";
                confirmationModalBody.innerHTML = `Are you sure you want to set <strong>${media.media_name}</strong> as the active landing page video?`;
                confirmActionBtn.onclick = async () => {
                    const formData = new FormData();
                    formData.append('action', 'set_active');
                    formData.append('id', selectedMediaId);
                    const response = await fetch('api_landing_media.php', { method: 'POST', body: formData });
                    const result = await response.json();
                    if (result.success) {
                        loadAndRenderMedia();
                    } else { alert('Error: ' + result.message); }
                    confirmationModal.hide();
                };
                confirmationModal.show();
            });
            loadAndRenderMedia();
        })();

        // --- START: SCRIPT FOR ABOUT PAGE MANAGEMENT ---
        (function() {
            const saveBtn = document.getElementById('save-all-about-changes-btn');
            const cancelBtn = document.getElementById('cancel-about-changes-btn');
            const clearMediaBtn = document.getElementById('clear-hero-media-btn');
            const clearMediaFlag = document.getElementById('clear-media-flag');

            async function loadAboutData() {
                try {
                    const response = await fetch('api_about.php?action=fetch_all');
                    const result = await response.json();
                    if (result.success) {
                        populateAboutForms(result.data);
                    } else {
                        alert('Error fetching About page data: ' + result.message);
                    }
                } catch(e) {
                    alert('An error occurred while loading About page data.');
                    console.error(e);
                }
            }

            function populateAboutForms(data) {
                // Main section
                if (data.main) {
                    document.getElementById('about-hero-title').value = data.main.title || '';
                    document.getElementById('about-hero-description').value = data.main.description || '';
                    const previewContainer = document.getElementById('about-hero-preview');
                    if (data.main.media_path && data.main.media_path.length > 0) {
                        const mediaPath = '../' + data.main.media_path;
                        previewContainer.innerHTML = data.main.media_type === 'video' 
                            ? `<video src="${mediaPath}" class="img-fluid" controls autoplay muted loop></video>` 
                            : `<img src="${mediaPath}" class="img-fluid" alt="Hero Preview">`;
                    } else {
                        previewContainer.innerHTML = `<p class="text-muted m-0">No media uploaded.</p>`;
                    }
                }

                // Content blocks
                const blocksContainer = document.getElementById('about-content-blocks-container');
                blocksContainer.innerHTML = '';
                if(data.content_blocks && data.content_blocks.length > 0) {
                    data.content_blocks.forEach(block => {
                        const clone = document.getElementById('about-text-block-template').content.cloneNode(true);
                        clone.querySelector('.block-content').value = block.content || '';
                        blocksContainer.appendChild(clone);
                    });
                }
                
                // Cards
                const cardsContainer = document.getElementById('about-cards-container');
                cardsContainer.innerHTML = '';
                if(data.cards && data.cards.length > 0) {
                    data.cards.forEach(card => {
                        const clone = document.getElementById('about-card-template').content.cloneNode(true);
                        clone.querySelector('.card-tab-title').value = card.tab_title || '';
                        clone.querySelector('.card-title').value = card.card_title || '';
                        clone.querySelector('.card-content').value = card.content || '';
                        cardsContainer.appendChild(clone);
                    });
                }
            }

            saveBtn.addEventListener('click', async () => {
                confirmationModalTitle.textContent = "Confirm Save";
                confirmationModalBody.textContent = 'Are you sure you want to save all changes to the About page?';
                confirmActionBtn.onclick = async () => {
                    const formData = new FormData(document.getElementById('about-main-form'));
                    formData.append('action', 'save_all');
                    
                    const blocks = Array.from(document.querySelectorAll('#about-content-blocks-container .dynamic-about-block')).map(el => ({ content: el.querySelector('.block-content').value }));
                    formData.append('content_blocks', JSON.stringify(blocks));

                    const cards = Array.from(document.querySelectorAll('#about-cards-container .dynamic-about-card')).map(el => ({
                        tabTitle: el.querySelector('.card-tab-title').value,
                        cardTitle: el.querySelector('.card-title').value,
                        content: el.querySelector('.card-content').value
                    }));
                    formData.append('cards', JSON.stringify(cards));

                    try {
                        const response = await fetch('api_about.php', { method: 'POST', body: formData });
                        const result = await response.json();
                        if(result.success) {
                            alert('About page saved successfully!');
                            clearMediaFlag.value = '0';
                            document.getElementById('about-hero-file').value = '';
                            loadAboutData();
                        } else {
                            alert('Error saving: ' + result.message);
                        }
                    } catch (e) {
                        alert('A critical error occurred while saving.');
                        console.error(e);
                    }
                    confirmationModal.hide();
                };
                confirmationModal.show();
            });

            cancelBtn.addEventListener('click', () => {
                confirmationModalTitle.textContent = "Confirm Cancel";
                confirmationModalBody.textContent = 'Are you sure you want to discard all changes? This will reload the last saved content.';
                confirmActionBtn.onclick = () => {
                    loadAboutData();
                    confirmationModal.hide();
                };
                confirmationModal.show();
            });
            
            clearMediaBtn.addEventListener('click', () => {
                document.getElementById('about-hero-file').value = '';
                document.getElementById('about-hero-preview').innerHTML = `<p class="text-muted m-0">Media will be removed upon saving.</p>`;
                clearMediaFlag.value = '1';
            });

            document.getElementById('add-text-block-btn').addEventListener('click', () => {
                const container = document.getElementById('about-content-blocks-container');
                const clone = document.getElementById('about-text-block-template').content.cloneNode(true);
                container.appendChild(clone);
            });
             document.getElementById('add-about-card-btn').addEventListener('click', () => {
                const container = document.getElementById('about-cards-container');
                const clone = document.getElementById('about-card-template').content.cloneNode(true);
                container.appendChild(clone);
            });

            // Event delegation for removing dynamic elements
            document.getElementById('about').addEventListener('click', e => {
                if (e.target.closest('.remove-about-block-btn')) {
                    e.target.closest('.dynamic-about-block').remove();
                }
                if (e.target.closest('.remove-about-card-btn')) {
                    e.target.closest('.dynamic-about-card').remove();
                }
            });

            // Event listener for About section tabs
            document.getElementById('about-edit-nav').addEventListener('click', e => {
                if (e.target.classList.contains('nav-link')) {
                    e.preventDefault();
                    const targetId = e.target.dataset.target;
                    document.querySelectorAll('#about-edit-nav .nav-link').forEach(link => link.classList.remove('active'));
                    e.target.classList.add('active');
                    document.querySelectorAll('.about-edit-pane').forEach(pane => pane.style.display = 'none');
                    document.getElementById(targetId).style.display = 'block';
                }
            });

            loadAboutData();
        })();

        function updateFabVisibility() {
            document.querySelectorAll('.fab-container').forEach(container => { container.style.display = 'none'; });
            const activeSection = document.querySelector('.content-section.active');
            if (activeSection) {
                const activeFabContainer = activeSection.querySelector('.fab-container');
                if (activeFabContainer) activeFabContainer.style.display = 'flex';
            }
        }
        
        // Initial call
        updateFabVisibility();
    });
    </script>
</body>
</html>

