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

// --- REMOVED STATIC DATA ---
// All data will now be fetched from the database via JavaScript.
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

    <!-- Custom styles for CMS enhancements -->
    <style>
        .table-responsive .table tr.selected {
            background-color: #e9ecef;
            box-shadow: 0 0 0 2px #0d6efd;
        }
        #about-edit-nav .nav-link.active, #blogs-edit-nav .nav-link.active {
            background-color: #800000; /* Maroon color */
            color: #ffffff;
            border-color: #800000;
        }
        #about-edit-nav .nav-link, #blogs-edit-nav .nav-link { color: #333; }
        .service-card.selected, .blog-card.selected, .partner-card.selected {
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

        /* Custom Alert Style */
        .custom-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1080; /* High z-index to appear over everything */
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        #confirmation-modal {
            z-index: 1060; /* Ensure it appears above other modals (like the partner editor) */
        }

        .partner-card {
            border: 2px solid #198754; /* Green border */
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            border-radius: 0.5rem; /* Slightly rounded corners for the card */
        }
        .partner-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .partner-card .card-img-top {
            height: 180px;
            object-fit: cover;
            background-color: #f8f9fa;
            border-top-left-radius: calc(0.5rem - 2px); /* Adjust for border */
            border-top-right-radius: calc(0.5rem - 2px);
        }

        .partner-card .partner-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 50%;
            border: 4px solid #198754; /* Green border */
            position: absolute;
            top: 140px; /* Position from top: image height (180) - half logo height (40) */
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .partner-card .card-body {
            padding-top: 50px; /* Space for the overlapping logo */
        }
        .btn-visit-site {
            background: linear-gradient(45deg, #1E4620, #2a7c2a);
            border: none;
            color: white !important;
            padding: 0.375rem 1rem;
            font-size: 0.9rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            text-decoration: none;
            display: inline-block;
        }
        .btn-visit-site:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            filter: brightness(1.1);
        }


        /* --- Dark Mode Styles --- */
        body.dark-mode .card,
        body.dark-mode .accordion-item,
        body.dark-mode .blog-section-card {
            background-color: #2b3035;
            color: #f8f9fa;
            border-color: #495057;
        }
        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #495057;
            color: #f8f9fa;
            border-color: #6c757d;
        }
        body.dark-mode .form-control::placeholder,
        body.dark-mode .form-select {
            color: #adb5bd;
        }
        body.dark-mode h5.card-title,
        body.dark-mode .form-label,
        body.dark-mode p.text-muted,
        body.dark-mode .card-text,
        body.dark-mode h6.text-muted,
        body.dark-mode .card-header,
        body.dark-mode .accordion-header {
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
        body.dark-mode .btn-outline-primary {
            color: #f8f9fa;
            border-color: #0d6efd;
        }
        body.dark-mode .btn-outline-primary:hover {
            background-color: #0d6efd;
        }
        body.dark-mode .accordion-button {
            background-color: #343a40;
            color: #f8f9fa;
        }
        body.dark-mode .accordion-button:not(.collapsed) {
            background-color: #495057;
            color: #f8f9fa;
        }
        /* Filter to make the default Bootstrap arrow white for dark mode */
        body.dark-mode .accordion-button::after {
            filter: invert(1) grayscale(100%) brightness(200%);
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
                             <li><a class="dropdown-item nav-link" href="#" data-target="newsletter">Newsletter</a></li>
                        </ul>
                    </div>
                    <nav class="nav nav-pills flex-sm-row content-nav d-none d-sm-flex">
                        <a class="flex-sm-fill text-sm-center nav-link active" href="#" data-target="landing-page">Landing Page</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="#" data-target="about">About</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="#" data-target="services">Services</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="#" data-target="blogs">Blogs</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="#" data-target="partners">Partners</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="#" data-target="footer">Footer</a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="#" data-target="newsletter">Newsletter</a>
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
                                    <tbody id="media-table-body"></tbody>
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
                            <div class="d-flex justify-content-between align-items-center mb-3"><h3>Edit About Page</h3></div>
                            <p class="text-muted small">Manage all content for the "About" section of your homepage.</p>
                            <nav class="nav nav-tabs mb-3" id="about-edit-nav">
                                <a class="nav-link active" href="#" data-target="about-main-section">Main Section</a>
                                <a class="nav-link" href="#" data-target="about-content-blocks">"Learn More" Paragraphs</a>
                                <a class="nav-link" href="#" data-target="about-cards-section">"Learn More" Tabs (Mission/Vision)</a>
                            </nav>
                            <div id="about-main-section" class="about-edit-pane active"><div class="card"><div class="card-body"><h5 class="card-title">Main Media, Title, and Description</h5><form id="about-main-form"><input type="hidden" id="clear-media-flag" name="clear_media" value="0"><div class="row"><div class="col-md-5"><div class="mb-3"><label for="about-hero-file" class="form-label">Hero Media (Photo or Video)</label><div class="input-group"><input type="file" class="form-control" id="about-hero-file" name="mediaFile" accept="image/*,video/mp4,video/mov,video/quicktime"><button class="btn btn-outline-danger" type="button" id="clear-hero-media-btn" title="Clear Media"><i class="bi bi-x-lg"></i></button></div><div id="about-hero-preview" class="mt-2 border rounded p-2" style="min-height: 350px; display: flex; flex-direction: column; align-items: center; justify-content: center;"></div></div></div><div class="col-md-7"><div class="mb-3"><label for="about-hero-title" class="form-label">Main Title</label><input type="text" class="form-control" id="about-hero-title" name="title"></div><div class="mb-3"><label for="about-hero-description" class="form-label">Main Description</label><textarea class="form-control" id="about-hero-description" name="description" rows="15"></textarea></div></div></div></form></div></div></div>
                            <div id="about-content-blocks" class="about-edit-pane" style="display: none;"><div class="card"><div class="card-body"><h5 class="card-title">"Learn More" Paragraphs</h5><p class="card-text text-muted">These paragraphs appear at the top of the expanded "Learn More" section.</p><div id="about-content-blocks-container"></div><hr><button class="btn btn-outline-primary" id="add-text-block-btn"><i class="bi bi-body-text me-2"></i>Add Text Paragraph</button></div></div></div>
                            <div id="about-cards-section" class="about-edit-pane" style="display: none;"><div class="card"><div class="card-body"><h5 class="card-title">"Learn More" Tabs (Mission, Vision, etc.)</h5><p class="card-text text-muted">These items will appear in the tabbed interface at the bottom of the "Learn More" section.</p><div id="about-cards-container"></div><hr><button class="btn btn-outline-primary" id="add-about-card-btn"><i class="bi bi-plus-square me-2"></i>Add New Card</button></div></div></div>
                             <div class="fab-container" style="display: none;">
                                <button id="cancel-about-changes-btn" class="btn btn-secondary btn-lg rounded-circle" title="Reload and discard changes"><i class="bi bi-arrow-counterclockwise"></i></button>
                                <button id="save-all-about-changes-btn" class="btn btn-success btn-lg rounded-circle" title="Save All Changes"><i class="bi bi-check-lg"></i></button>
                            </div>
                        </div>
                         <!-- Services Section -->
                        <div id="services" class="content-section">
                            <div class="d-flex justify-content-between align-items-center mb-3"><h3>Edit Service Pages</h3></div>
                            <p class="text-muted small">Manage content for the service pages.</p>
                            <div class="mb-4"><label for="service-selector" class="form-label">Select a service page to edit:</label><select class="form-select" id="service-selector"><option selected disabled>Choose...</option><option value="caregiver">Caregiver Permit</option><option value="family_permit">Family Permit</option><option value="lmia">LMIA</option><option value="pr">Permanent Residency</option><option value="study_permit">Study Permit</option><option value="visit_permit">Visit Permit</option><option value="work_permit">Work Permit</option></select></div>
                            <div id="service-editor-container" style="display: none;"><form id="service-editor-form"><input type="hidden" id="service-id-field" name="service_id"><input type="hidden" id="existing-hero-image-path" name="existing_hero_image_path"><div class="card mb-4"><div class="card-header"><h5 class="mb-0">Main Hero Section</h5></div><div class="card-body"><div class="mb-3"><label for="service-hero-title" class="form-label">Hero Title</label><input type="text" class="form-control" id="service-hero-title" name="hero_title"></div><div class="mb-3"><label for="service-hero-description" class="form-label">Hero Description</label><textarea class="form-control" id="service-hero-description" name="hero_description" rows="6"></textarea></div><div class="mb-3"><label for="service-hero-image-file" class="form-label">Hero Background Image</label><input type="file" class="form-control" id="service-hero-image-file" name="hero_image_file" accept="image/*"><div id="service-hero-image-preview" class="mt-2 border rounded p-2" style="min-height: 100px;"></div></div></div></div><div class="card"><div class="card-header"><h5 class="mb-0">Page Content Tabs</h5></div><div class="card-body"><div class="accordion" id="service-tabs-accordion"></div></div></div></form></div>
                            <div id="service-placeholder" class="text-center text-muted p-5"><p>Please select a service page above to begin editing.</p></div>
                            <div class="fab-container" style="display: none;">
                                <button id="cancel-service-changes-btn" class="btn btn-secondary btn-lg rounded-circle" title="Reload and discard changes"><i class="bi bi-arrow-counterclockwise"></i></button>
                                <button id="save-service-changes-btn" class="btn btn-success btn-lg rounded-circle" title="Save Changes"><i class="bi bi-check-lg"></i></button>
                            </div>
                        </div>
                        <!-- Blogs Section -->
                        <div id="blogs" class="content-section">
                            <div class="d-flex justify-content-between align-items-center mb-3"><h3>Edit Blog Pages</h3></div>
                             <p class="text-muted small">Manage content for the blog pages.</p>
                            <div class="mb-4"><label for="blog-selector" class="form-label">Select a blog page to edit:</label><select class="form-select" id="blog-selector"><option selected disabled>Choose...</option><option value="canada">A Calling to Canada</option><option value="minifair">IELTS Mini Fair</option><option value="visitation">Bridging Education and Industry</option><option value="calamba">Visit to Laguna</option><option value="la-salle">De La Salle Lipa Visit</option><option value="sti-lipa">STI College Lipa Visit</option><option value="tacloban">Visit to Tacloban</option></select></div>
                            <div id="blog-editor-container" style="display: none;">
                                <form id="blog-editor-form">
                                    <input type="hidden" id="blog-page-key-field" name="page_key">
                                    <div class="card mb-4">
                                        <div class="card-header"><h5 class="mb-0">Main Blog Details</h5></div>
                                        <div class="card-body">
                                            <div class="mb-3"><label for="blog-title" class="form-label">Blog Title</label><input type="text" class="form-control" id="blog-title" name="title"></div>
                                            <div class="mb-3"><label for="blog-author" class="form-label">Author</label><input type="text" class="form-control" id="blog-author" name="author"></div>
                                            <div class="mb-3"><label for="blog-main-content" class="form-label">Main Content / Introduction</label><textarea class="form-control" id="blog-main-content" name="main_content" rows="8"></textarea></div>
                                            <div class="mb-3"><label for="blog-main-image-file" class="form-label">Main Image</label><input type="file" class="form-control" id="blog-main-image-file" name="main_image_file" accept="image/*"><div id="blog-main-image-preview" class="mt-2 border rounded p-2" style="min-height: 100px;"></div></div>
                                        </div>
                                    </div>
                                    <div class="card"><div class="card-header"><h5 class="mb-0">Blog Content Sections</h5></div><div class="card-body" id="blog-sections-container"></div></div>
                                </form>
                            </div>
                            <div id="blog-placeholder" class="text-center text-muted p-5"><p>Please select a blog page above to begin editing.</p></div>
                             <div class="fab-container" style="display: none;">
                                <button id="cancel-blog-changes-btn" class="btn btn-secondary btn-lg rounded-circle" title="Reload and discard changes"><i class="bi bi-arrow-counterclockwise"></i></button>
                                <button id="save-blog-changes-btn" class="btn btn-success btn-lg rounded-circle" title="Save Changes"><i class="bi bi-check-lg"></i></button>
                            </div>
                        </div>
                        <!-- Partners Section -->
                        <div id="partners" class="content-section">
                            <div class="d-flex justify-content-between align-items-center mb-3"><h3>Edit Partners</h3></div>
                            <p class="text-muted small">Manage the partners displayed on your homepage. Click a card to select it for editing or deletion.</p>
                             <div id="partners-list-container" class="row g-4">
                                <!-- Partner cards will be loaded here by JavaScript -->
                             </div>
                             <div class="fab-container" style="display: none;">
                                <button id="edit-partner-btn" class="btn btn-warning btn-lg rounded-circle" title="Edit Selected Partner" disabled><i class="bi bi-pencil-fill"></i></button>
                                <button id="delete-partner-btn" class="btn btn-danger btn-lg rounded-circle" title="Delete Selected Partner" disabled><i class="bi bi-trash-fill"></i></button>
                                <button id="add-partner-btn" class="btn btn-primary btn-lg rounded-circle" title="Add New Partner"><i class="bi bi-plus-lg"></i></button>
                            </div>
                        </div>
                        <!-- Footer Section -->
                        <div id="footer" class="content-section">
                            <div class="d-flex justify-content-between align-items-center mb-3"><h3>Edit Footer Content</h3></div>
                            <p class="text-muted small">Manage the text, contact details, and links displayed in the website footer.</p>
                            <form id="footer-form">
                                <div class="card mb-4">
                                    <div class="card-header"><h5 class="mb-0">Newsletter Section</h5></div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="footer-newsletter-title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="footer-newsletter-title" name="newsletter_title">
                                        </div>
                                        <div class="mb-3">
                                            <label for="footer-newsletter-text" class="form-label">Descriptive Text</label>
                                            <input type="text" class="form-control" id="footer-newsletter-text" name="newsletter_text">
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-4">
                                    <div class="card-header"><h5 class="mb-0">Contact Information ("Get In Touch")</h5></div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="footer-contact-email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="footer-contact-email" name="contact_email">
                                        </div>
                                        <div class="mb-3">
                                            <label for="footer-contact-phone" class="form-label">Phone Number(s)</label>
                                            <input type="text" class="form-control" id="footer-contact-phone" name="contact_phone">
                                        </div>
                                        <div class="mb-3">
                                            <label for="footer-contact-address" class="form-label">Address</label>
                                            <textarea class="form-control" id="footer-contact-address" name="contact_address" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-4">
                                    <div class="card-header"><h5 class="mb-0">Social Media Links</h5></div>
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                            <input type="url" class="form-control" id="footer-facebook-url" name="facebook_url" placeholder="Facebook URL">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-twitter-x"></i></span>
                                            <input type="url" class="form-control" id="footer-twitter-url" name="twitter_url" placeholder="Twitter/X URL">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                            <input type="url" class="form-control" id="footer-instagram-url" name="instagram_url" placeholder="Instagram URL">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-linkedin"></i></span>
                                            <input type="url" class="form-control" id="footer-linkedin-url" name="linkedin_url" placeholder="LinkedIn URL">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-tiktok"></i></span>
                                            <input type="url" class="form-control" id="footer-tiktok-url" name="tiktok_url" placeholder="TikTok URL">
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header"><h5 class="mb-0">Footer Credits</h5></div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8 mb-3 mb-md-0">
                                                <label for="footer-credits-text" class="form-label">Company Name</label>
                                                <input type="text" class="form-control" id="footer-credits-text" name="credits_text">
                                            </div>
                                            <div class="col-md-4">
                                                 <label for="footer-credits-year" class="form-label">Copyright Year</label>
                                                <input type="text" class="form-control" id="footer-credits-year" name="credits_year" placeholder="e.g., 2025">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                             <div class="fab-container" style="display: none;">
                                <button id="cancel-footer-changes-btn" class="btn btn-secondary btn-lg rounded-circle" title="Reload and discard changes"><i class="bi bi-arrow-counterclockwise"></i></button>
                                <button id="save-footer-changes-btn" class="btn btn-success btn-lg rounded-circle" title="Save All Changes"><i class="bi bi-check-lg"></i></button>
                            </div>
                        </div>
                         <!-- Newsletter Section -->
                        <div id="newsletter" class="content-section">
                            <div class="d-flex justify-content-between align-items-center mb-3"><h3>Newsletter Subscribers</h3></div>
                            <p class="text-muted small">Here is the list of clients who have subscribed to your newsletter.</p>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Email Address</th>
                                            <th scope="col">Subscription Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="subscriber-table-body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- ALL MODALS AND TEMPLATES -->
    <div class="modal fade" id="uploadMediaModal" tabindex="-1" data-bs-backdrop="static"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="uploadMediaModalLabel">Add New Hero Media</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><form id="upload-form" novalidate><input type="hidden" id="mediaId" name="id" value=""><div class="mb-3"><label for="mediaName" class="form-label">Media Name</label><input type="text" class="form-control" id="mediaName" name="mediaName" required></div><div class="mb-3"><label for="uploaderName" class="form-label">Uploader</label><input type="text" class="form-control" id="uploaderName" name="uploaderName" value="<?php echo htmlspecialchars($_SESSION['firstName'] . ' ' . $_SESSION['lastName']); ?>" required></div><div class="mb-3"><label for="mediaFile" class="form-label">Upload Video</label><input class="form-control" type="file" id="mediaFile" name="mediaFile" accept="video/*" required><div class="form-text" id="mediaFileHelp">Select a new video file to upload.</div></div></form></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="save-media-btn">Save Media</button></div></div></div></div>
    <div class="modal fade" id="confirmation-modal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="confirmation-title">Confirm Action</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="confirmation-body"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="confirm-action-btn">Confirm</button></div></div></div></div>
    <div class="modal fade" id="landing-preview-modal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="landing-preview-title">Media Preview</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="landing-preview-body" class="text-center"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div></div></div></div>
    
    <!-- Partner Modal -->
    <div class="modal fade" id="partnerModal" tabindex="-1" data-bs-backdrop="static"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="partnerModalLabel">Add New Partner</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><form id="partner-form" novalidate><input type="hidden" id="partnerId" name="id"><div class="mb-3"><label for="partnerName" class="form-label">Partner Name</label><input type="text" class="form-control" id="partnerName" name="name" required></div><div class="mb-3"><label for="partnerLink" class="form-label">Website Link</label><input type="url" class="form-control" id="partnerLink" name="website_link" placeholder="https://example.com" required></div><div class="row"><div class="col-md-6"><div class="mb-3"><label for="partnerLogoFile" class="form-label">Partner Logo</label><input class="form-control" type="file" id="partnerLogoFile" name="logoFile" accept="image/png, image/jpeg, image/gif, image/webp"><div id="logo-preview" class="mt-2 text-center"></div><div class="form-text">Upload a new logo to replace the existing one. Recommended: a square-like image.</div></div></div><div class="col-md-6"><div class="mb-3"><label for="partnerBgFile" class="form-label">Background Image</label><input class="form-control" type="file" id="partnerBgFile" name="bgImageFile" accept="image/jpeg, image/png, image/webp"><div id="bg-preview" class="mt-2 text-center"></div><div class="form-text">Upload a new background to replace the existing one.</div></div></div></div></form></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="save-partner-btn">Save Partner</button></div></div></div></div>

    <template id="about-text-block-template"><div class="p-3 border rounded mb-3 dynamic-about-block" data-type="text"><div class="d-flex justify-content-between align-items-center mb-2"><h6 class="mb-0 text-muted">Text Paragraph</h6><button type="button" class="btn-close remove-about-block-btn"></button></div><textarea class="form-control block-content" rows="5" placeholder="Enter paragraph text here..."></textarea></div></template>
    <template id="about-card-template"><div class="p-3 border rounded mb-3 dynamic-about-card"><div class="d-flex justify-content-between align-items-center mb-2"><h6 class="mb-0 text-muted">Tabbed Card</h6><button type="button" class="btn-close remove-about-card-btn"></button></div><div class="row"><div class="col-md-6 mb-2"><label class="form-label small">Tab Title</label><input type="text" class="form-control card-tab-title" placeholder="e.g., Mission"></div><div class="col-md-6 mb-2"><label class="form-label small">Card Title</label><input type="text" class="form-control card-title" placeholder="e.g., Mission Statement"></div></div><div class="mb-2"><label class="form-label small">Card Content</label><textarea class="form-control card-content" rows="4"></textarea></div></div></template>
    <template id="service-tab-accordion-template"><div class="accordion-item"><h2 class="accordion-header" id="heading-template"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-template" aria-expanded="false" aria-controls="collapse-template"></button></h2><div id="collapse-template" class="accordion-collapse collapse" aria-labelledby="heading-template" data-bs-parent="#service-tabs-accordion"><div class="accordion-body"><input type="hidden" class="tab-id-field" name="tab_id"><input type="hidden" class="existing-tab-image-path" name="existing_tab_image_path"><div class="mb-3"><label class="form-label">Tab Content</label><textarea class="form-control tab-content-field" rows="15"></textarea></div><div class="mb-3"><label class="form-label">Tab Image</label><input type="file" class="form-control tab-image-file-field" accept="image/*"><div class="mt-2 border rounded p-2 tab-image-preview" style="min-height: 100px;"></div></div></div></div></div></template>
    <template id="blog-section-template"><div class="blog-section-card mb-3"><input type="hidden" class="blog-section-id-field"><div class="mb-3"><label class="form-label fw-bold">Section Title</label><input type="text" class="form-control blog-section-title-field"></div><div class="mb-3"><label class="form-label">Section Content</label><textarea class="form-control blog-section-content-field" rows="6"></textarea></div><div class="mb-3"><label class="form-label">Section Image</label><input type="file" class="form-control blog-section-image-file-field" accept="image/*"><div class="mt-2 border rounded p-2 blog-section-image-preview" style="min-height: 100px;"></div></div></div></template>
    
    <!-- Partner Card Template -->
    <template id="partner-card-template"><div class="col-lg-4 col-md-6"><div class="card partner-card h-100 position-relative text-center" style="cursor: pointer;"><img class="card-img-top bg-image-placeholder"><img class="partner-logo logo-placeholder"><div class="card-body"><h5 class="card-title partner-name-placeholder mb-3"></h5><a href="#" class="btn-visit-site partner-link-placeholder" target="_blank" rel="noopener noreferrer">Visit Site <i class="bi bi-box-arrow-up-right ms-1"></i></a></div></div></div></template>
    
    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- START: Custom Success Alert ---
        function showSuccessAlert(message) {
            const existingAlert = document.getElementById('custom-success-alert');
            if (existingAlert) {
                existingAlert.remove();
            }

            const alertEl = document.createElement('div');
            alertEl.id = 'custom-success-alert';
            alertEl.className = 'alert alert-success d-flex align-items-center custom-alert';
            alertEl.setAttribute('role', 'alert');
            alertEl.innerHTML = `
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>${message}</div>
            `;
            document.body.appendChild(alertEl);
            
            // Force reflow to enable transition
            alertEl.offsetHeight; 

            // Fade in
            alertEl.style.display = 'block';
            alertEl.style.opacity = 1;

            // Automatically remove after 3 seconds
            setTimeout(() => {
                alertEl.style.opacity = 0;
                // Remove from DOM after transition ends
                alertEl.addEventListener('transitionend', () => alertEl.remove());
            }, 3000);
        }
        // --- END: Custom Success Alert ---

        const navLinks = document.querySelectorAll('.content-nav .nav-link');
        const contentSections = document.querySelectorAll('.content-section');
        const dropdownButton = document.getElementById('contentNavDropdown');
        function setActiveNav(targetId) { const activeLink = document.querySelector(`.content-nav .nav-link[data-target="${targetId}"]`); if (!activeLink) return; if (dropdownButton) { dropdownButton.textContent = activeLink.textContent; } navLinks.forEach(link => { link.classList.toggle('active', link.getAttribute('data-target') === targetId); }); contentSections.forEach(section => { section.classList.toggle('active', section.id === targetId); }); updateFabVisibility(); }
        navLinks.forEach(link => { link.addEventListener('click', function(e) { e.preventDefault(); const targetId = this.getAttribute('data-target'); setActiveNav(targetId); }); });
        (function handleDeepLink() { const hash = window.location.hash; const targetId = hash ? hash.substring(1) : null; const initialActiveLink = document.querySelector('.content-nav .nav-link.active'); if (targetId) { setActiveNav(targetId); } else if (initialActiveLink) { setActiveNav(initialActiveLink.getAttribute('data-target')); } })();
        const confirmationModalEl = document.getElementById('confirmation-modal'); const confirmationModal = new bootstrap.Modal(confirmationModalEl); const confirmationModalBody = document.getElementById('confirmation-body'); const confirmActionBtn = document.getElementById('confirm-action-btn'); const confirmationModalTitle = document.getElementById('confirmation-title');
        
        // --- START: SCRIPT FOR LANDING PAGE MANAGEMENT ---
        (function() {
            let landingMediaData = []; let selectedMediaId = null; const mediaTableBody = document.getElementById('media-table-body'); const addLandingBtn = document.getElementById('add-landing-btn'); const editLandingBtn = document.getElementById('edit-landing-btn'); const deleteLandingBtn = document.getElementById('delete-landing-btn'); const previewLandingBtn = document.getElementById('preview-landing-btn'); const setActiveLandingBtn = document.getElementById('set-active-landing-btn'); const uploadModal = new bootstrap.Modal(document.getElementById('uploadMediaModal')); const previewModal = new bootstrap.Modal(document.getElementById('landing-preview-modal')); const uploadForm = document.getElementById('upload-form'); const saveMediaBtn = document.getElementById('save-media-btn');
            async function loadAndRenderMedia() { try { const response = await fetch('api_landing_media.php?action=fetch'); const result = await response.json(); if (result.success) { landingMediaData = result.data; renderTable(); } else { alert('Error fetching media: ' + result.message); } } catch (error) { console.error('Fetch error:', error); alert('A network error occurred. Please try again.'); } }
            function renderTable() { mediaTableBody.innerHTML = ''; if (landingMediaData.length === 0) { mediaTableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No media has been uploaded yet.</td></tr>'; return; } landingMediaData.forEach(media => { const row = mediaTableBody.insertRow(); row.dataset.id = media.id; row.dataset.filePath = media.file_path; row.dataset.isActive = media.is_active; const statusCell = row.insertCell(); if (media.is_active == 1) { statusCell.innerHTML = '<span class="badge bg-success">Active</span>'; } row.insertCell().textContent = media.media_name; row.insertCell().textContent = media.uploader; row.insertCell().textContent = new Date(media.upload_date).toLocaleDateString(); row.insertCell().textContent = media.file_path; if (parseInt(media.id) === selectedMediaId) { row.classList.add('selected'); } }); }
            function updateFabState() { const isSelected = selectedMediaId !== null; editLandingBtn.disabled = !isSelected; deleteLandingBtn.disabled = !isSelected; previewLandingBtn.disabled = !isSelected; const selectedItem = landingMediaData.find(m => m.id == selectedMediaId); setActiveLandingBtn.disabled = !isSelected || (selectedItem && selectedItem.is_active == 1); }
            function selectRow(mediaId) { selectedMediaId = (selectedMediaId === mediaId) ? null : mediaId; renderTable(); updateFabState(); }
            function resetAndPrepareModal(mode = 'add', media = null) { uploadForm.reset(); uploadForm.classList.remove('was-validated'); const modalTitle = document.getElementById('uploadMediaModalLabel'); const mediaFileInput = document.getElementById('mediaFile'); const mediaFileHelp = document.getElementById('mediaFileHelp'); document.getElementById('mediaId').value = ''; if (mode === 'add') { modalTitle.textContent = 'Add New Hero Media'; saveMediaBtn.textContent = 'Add Media'; saveMediaBtn.dataset.mode = 'add'; mediaFileInput.required = true; mediaFileHelp.textContent = 'Please select a video to upload.'; } else if (mode === 'edit' && media) { modalTitle.textContent = `Edit Media: ${media.media_name}`; saveMediaBtn.textContent = 'Update Media'; saveMediaBtn.dataset.mode = 'edit'; document.getElementById('mediaId').value = media.id; document.getElementById('mediaName').value = media.media_name; document.getElementById('uploaderName').value = media.uploader; mediaFileInput.required = false; mediaFileHelp.textContent = `Current file: ${media.file_path}. Uploading a new file will replace it.`; } }
            mediaTableBody.addEventListener('click', e => { const row = e.target.closest('tr'); if (row && row.dataset.id) { selectRow(parseInt(row.dataset.id)); } });
            addLandingBtn.addEventListener('click', () => { resetAndPrepareModal('add'); uploadModal.show(); });
            editLandingBtn.addEventListener('click', () => { if (selectedMediaId === null) return; const media = landingMediaData.find(m => m.id == selectedMediaId); resetAndPrepareModal('edit', media); uploadModal.show(); });
            saveMediaBtn.addEventListener('click', async () => { if (!uploadForm.checkValidity()) { uploadForm.reportValidity(); return; } confirmationModalTitle.textContent = "Confirm Save"; confirmationModalBody.textContent = 'Are you sure you want to save this media entry?'; confirmActionBtn.onclick = async () => { confirmationModal.hide(); const formData = new FormData(uploadForm); const mode = saveMediaBtn.dataset.mode; formData.append('action', mode); try { const response = await fetch('api_landing_media.php', { method: 'POST', body: formData }); const resultText = await response.text(); try { const result = JSON.parse(resultText); if (result.success) { uploadModal.hide(); loadAndRenderMedia(); showSuccessAlert('Hero media saved successfully!'); } else { alert('Error: ' + result.message); } } catch (e) { console.error('Failed to parse JSON:', resultText); alert('An unexpected server error occurred.'); } } catch (error) { console.error('Save error:', error); alert('A network error occurred while saving.'); } }; confirmationModal.show(); });
            deleteLandingBtn.addEventListener('click', () => { if (selectedMediaId === null) return; const media = landingMediaData.find(m => m.id == selectedMediaId); confirmationModalTitle.textContent = "Confirm Deletion"; confirmationModalBody.innerHTML = `Are you sure you want to delete the media: <strong>${media.media_name}</strong>? This cannot be undone.`; confirmActionBtn.onclick = async () => { const formData = new FormData(); formData.append('action', 'delete'); formData.append('id', selectedMediaId); const response = await fetch('api_landing_media.php', { method: 'POST', body: formData }); const result = await response.json(); if (result.success) { selectedMediaId = null; loadAndRenderMedia(); } else { alert('Error: ' + result.message); } confirmationModal.hide(); }; confirmationModal.show(); });
            previewLandingBtn.addEventListener('click', () => { if (selectedMediaId === null) return; const media = landingMediaData.find(m => m.id == selectedMediaId); document.getElementById('landing-preview-title').textContent = `Preview: ${media.media_name}`; const previewBody = document.getElementById('landing-preview-body'); const previewPath = '../' + media.file_path; let videoType = 'video/mp4'; let warningHTML = ''; if (previewPath.toLowerCase().endsWith('.mov')) { videoType = 'video/quicktime'; warningHTML = `<p class="text-info small mt-2 mb-0"><i class="bi bi-info-circle-fill"></i> If this video doesn't play, consider using the MP4 format for better browser compatibility.</p>`; } previewBody.innerHTML = `<video src="${previewPath}" type="${videoType}" class="img-fluid rounded" controls autoplay muted loop style="width: 100%; height: auto;"></video>${warningHTML}`; previewModal.show(); });
            setActiveLandingBtn.addEventListener('click', () => { if (selectedMediaId === null) return; const media = landingMediaData.find(m => m.id == selectedMediaId); confirmationModalTitle.textContent = "Confirm New Active Video"; confirmationModalBody.innerHTML = `Are you sure you want to set <strong>${media.media_name}</strong> as the active landing page video?`; confirmActionBtn.onclick = async () => { const formData = new FormData(); formData.append('action', 'set_active'); formData.append('id', selectedMediaId); const response = await fetch('api_landing_media.php', { method: 'POST', body: formData }); const result = await response.json(); if (result.success) { loadAndRenderMedia(); } else { alert('Error: ' + result.message); } confirmationModal.hide(); }; confirmationModal.show(); });
            loadAndRenderMedia();
        })();

        // --- START: SCRIPT FOR ABOUT PAGE MANAGEMENT ---
        (function() {
            const saveBtn = document.getElementById('save-all-about-changes-btn'); const cancelBtn = document.getElementById('cancel-about-changes-btn'); const clearMediaBtn = document.getElementById('clear-hero-media-btn'); const clearMediaFlag = document.getElementById('clear-media-flag'); const heroFileInput = document.getElementById('about-hero-file'); const heroPreviewContainer = document.getElementById('about-hero-preview');
            async function loadAboutData() { try { const response = await fetch('api_about.php?action=fetch_all'); const result = await response.json(); if (result.success) { populateAboutForms(result.data); } else { alert('Error fetching About page data: ' + result.message); } } catch(e) { alert('An error occurred while loading About page data.'); console.error(e); } }
            function populateAboutForms(data) { if (data.main) { document.getElementById('about-hero-title').value = data.main.title || ''; document.getElementById('about-hero-description').value = data.main.description || ''; if (data.main.media_path && data.main.media_path.length > 0) { const mediaPath = '../' + data.main.media_path; let previewHTML = ''; let warningHTML = ''; if (data.main.media_type === 'video') { let videoType = 'video/mp4'; if (mediaPath.toLowerCase().endsWith('.mov')) { videoType = 'video/quicktime'; warningHTML = `<p class="text-info small mt-1 mb-0 text-center"><i class="bi bi-info-circle-fill"></i> If this video doesn't display, consider using MP4 format.</p>`; } previewHTML = `<video src="${mediaPath}" type="${videoType}" class="img-fluid" controls autoplay muted loop style="max-height: 350px;"></video>`; } else { previewHTML = `<img src="${mediaPath}" class="img-fluid" alt="Hero Preview" style="max-height: 350px;">`; } heroPreviewContainer.innerHTML = previewHTML + warningHTML; } else { heroPreviewContainer.innerHTML = `<p class="text-muted m-0">No media uploaded.</p>`; } } const blocksContainer = document.getElementById('about-content-blocks-container'); blocksContainer.innerHTML = ''; if(data.content_blocks && data.content_blocks.length > 0) { data.content_blocks.forEach(block => { const clone = document.getElementById('about-text-block-template').content.cloneNode(true); clone.querySelector('.block-content').value = block.content || ''; blocksContainer.appendChild(clone); }); } const cardsContainer = document.getElementById('about-cards-container'); cardsContainer.innerHTML = ''; if(data.cards && data.cards.length > 0) { data.cards.forEach(card => { const clone = document.getElementById('about-card-template').content.cloneNode(true); clone.querySelector('.card-tab-title').value = card.tab_title || ''; clone.querySelector('.card-title').value = card.card_title || ''; clone.querySelector('.card-content').value = card.content || ''; cardsContainer.appendChild(clone); }); } }
            heroFileInput.addEventListener('change', function(event) { const file = event.target.files[0]; if (file) { const objectURL = URL.createObjectURL(file); let previewHTML = ''; if (file.type.startsWith('video/')) { previewHTML = `<video src="${objectURL}" class="img-fluid" controls autoplay muted loop style="max-height: 350px;"></video>`; } else if (file.type.startsWith('image/')) { previewHTML = `<img src="${objectURL}" class="img-fluid" alt="New Preview" style="max-height: 350px;">`; } else { previewHTML = `<p class="text-muted m-0">File type not supported for preview.</p>`; } heroPreviewContainer.innerHTML = previewHTML; clearMediaFlag.value = '0'; } });
            saveBtn.addEventListener('click', async () => { confirmationModalTitle.textContent = "Confirm Save"; confirmationModalBody.textContent = 'Are you sure you want to save all changes to the About page?'; confirmActionBtn.onclick = async () => { const formData = new FormData(document.getElementById('about-main-form')); formData.append('action', 'save_all'); const blocks = Array.from(document.querySelectorAll('#about-content-blocks-container .dynamic-about-block')).map(el => ({ content: el.querySelector('.block-content').value })); formData.append('content_blocks', JSON.stringify(blocks)); const cards = Array.from(document.querySelectorAll('#about-cards-container .dynamic-about-card')).map(el => ({ tabTitle: el.querySelector('.card-tab-title').value, cardTitle: el.querySelector('.card-title').value, content: el.querySelector('.card-content').value })); formData.append('cards', JSON.stringify(cards)); try { const response = await fetch('api_about.php', { method: 'POST', body: formData }); const result = await response.json(); if(result.success) { showSuccessAlert('About page changes saved successfully!'); clearMediaFlag.value = '0'; heroFileInput.value = ''; loadAboutData(); } else { alert('Error saving: ' + result.message); } } catch (e) { alert('A critical error occurred while saving.'); console.error(e); } confirmationModal.hide(); }; confirmationModal.show(); });
            cancelBtn.addEventListener('click', () => { confirmationModalTitle.textContent = "Confirm Cancel"; confirmationModalBody.textContent = 'Are you sure you want to discard all changes? This will reload the last saved content.'; confirmActionBtn.onclick = () => { loadAboutData(); confirmationModal.hide(); }; confirmationModal.show(); });
            clearMediaBtn.addEventListener('click', () => { heroFileInput.value = ''; heroPreviewContainer.innerHTML = `<p class="text-muted m-0">Media will be removed upon saving.</p>`; clearMediaFlag.value = '1'; });
            document.getElementById('add-text-block-btn').addEventListener('click', () => { const container = document.getElementById('about-content-blocks-container'); const clone = document.getElementById('about-text-block-template').content.cloneNode(true); container.appendChild(clone); });
            document.getElementById('add-about-card-btn').addEventListener('click', () => { const container = document.getElementById('about-cards-container'); const clone = document.getElementById('about-card-template').content.cloneNode(true); container.appendChild(clone); });
            document.getElementById('about').addEventListener('click', e => { if (e.target.closest('.remove-about-block-btn')) { e.target.closest('.dynamic-about-block').remove(); } if (e.target.closest('.remove-about-card-btn')) { e.target.closest('.dynamic-about-card').remove(); } });
            document.getElementById('about-edit-nav').addEventListener('click', e => { if (e.target.classList.contains('nav-link')) { e.preventDefault(); const targetId = e.target.dataset.target; document.querySelectorAll('#about-edit-nav .nav-link').forEach(link => link.classList.remove('active')); e.target.classList.add('active'); document.querySelectorAll('.about-edit-pane').forEach(pane => pane.style.display = 'none'); document.getElementById(targetId).style.display = 'block'; } });
            loadAboutData();
        })();
        
        // --- START: SCRIPT FOR SERVICES PAGE MANAGEMENT ---
        (function() {
            const selector = document.getElementById('service-selector'); const editorContainer = document.getElementById('service-editor-container'); const placeholder = document.getElementById('service-placeholder'); const accordionContainer = document.getElementById('service-tabs-accordion'); const saveBtn = document.getElementById('save-service-changes-btn'); const cancelBtn = document.getElementById('cancel-service-changes-btn'); let currentServiceKey = null;
            async function loadServiceData(serviceKey) { currentServiceKey = serviceKey; if (!serviceKey) { editorContainer.style.display = 'none'; placeholder.style.display = 'block'; return; } editorContainer.style.display = 'block'; placeholder.style.display = 'none'; try { const response = await fetch(`api_services.php?action=fetch&service_key=${serviceKey}`); const result = await response.json(); if(result.success) { populateServiceForm(result.data); } else { alert(`Error fetching data for ${serviceKey}: ${result.message}`); } } catch(e) { console.error('Fetch error:', e); alert('A network error occurred.'); } }
            function populateServiceForm(data) { document.getElementById('service-id-field').value = data.id; document.getElementById('service-hero-title').value = data.hero_title || ''; document.getElementById('service-hero-description').value = data.hero_description || ''; const heroPreview = document.getElementById('service-hero-image-preview'); document.getElementById('existing-hero-image-path').value = data.hero_image_path || ''; if(data.hero_image_path) { heroPreview.innerHTML = `<img src="../${data.hero_image_path}" class="img-fluid rounded" alt="Hero Preview">`; } else { heroPreview.innerHTML = '<p class="text-muted m-0">No hero image set.</p>'; } accordionContainer.innerHTML = ''; const template = document.getElementById('service-tab-accordion-template'); data.tabs.forEach((tab, index) => { const clone = template.content.cloneNode(true); const tabTitle = tab.tab_key.charAt(0).toUpperCase() + tab.tab_key.slice(1); clone.querySelector('.accordion-header').id = `heading-${tab.id}`; const button = clone.querySelector('.accordion-button'); button.textContent = tabTitle; button.dataset.bsTarget = `#collapse-${tab.id}`; button.setAttribute('aria-controls', `collapse-${tab.id}`); const collapse = clone.querySelector('.accordion-collapse'); collapse.id = `collapse-${tab.id}`; collapse.setAttribute('aria-labelledby', `heading-${tab.id}`); if (index === 0) { button.classList.remove('collapsed'); collapse.classList.add('show'); } clone.querySelector('.tab-content-field').value = tab.content || ''; clone.querySelector('.tab-id-field').value = tab.id; clone.querySelector('.existing-tab-image-path').value = tab.image_path || ''; const tabImagePreview = clone.querySelector('.tab-image-preview'); if (tab.image_path) { tabImagePreview.innerHTML = `<img src="../${tab.image_path}" class="img-fluid rounded" alt="Tab Image Preview">`; } else { tabImagePreview.innerHTML = '<p class="text-muted m-0">No image for this tab.</p>'; } clone.querySelector('.tab-image-file-field').name = `tab_image_file_${tab.id}`; accordionContainer.appendChild(clone); }); }
            selector.addEventListener('change', () => { loadServiceData(selector.value); });
            cancelBtn.addEventListener('click', () => { if (currentServiceKey) { confirmationModalTitle.textContent = "Confirm Cancel"; confirmationModalBody.textContent = 'Are you sure you want to discard changes? This will reload the last saved content.'; confirmActionBtn.onclick = () => { loadServiceData(currentServiceKey); confirmationModal.hide(); }; confirmationModal.show(); } });
            saveBtn.addEventListener('click', () => { confirmationModalTitle.textContent = "Confirm Save"; confirmationModalBody.textContent = 'Are you sure you want to save these changes?'; confirmActionBtn.onclick = async () => { confirmationModal.hide(); const form = document.getElementById('service-editor-form'); const formData = new FormData(form); formData.append('action', 'update'); const tabsData = []; document.querySelectorAll('#service-tabs-accordion .accordion-item').forEach(item => { tabsData.push({ id: item.querySelector('.tab-id-field').value, content: item.querySelector('.tab-content-field').value, existing_image_path: item.querySelector('.existing-tab-image-path').value }); }); formData.append('tabs', JSON.stringify(tabsData)); try { const response = await fetch('api_services.php', { method: 'POST', body: formData }); const result = await response.json(); if (result.success) { showSuccessAlert('Service page updated successfully!'); loadServiceData(currentServiceKey); } else { alert('Error updating service page: ' + result.message); } } catch (e) { alert('A critical error occurred while saving.'); console.error(e); } }; confirmationModal.show(); });
        })();

        // --- START: SCRIPT FOR BLOGS PAGE MANAGEMENT ---
        (function() {
            const selector = document.getElementById('blog-selector'); const editorContainer = document.getElementById('blog-editor-container'); const form = document.getElementById('blog-editor-form'); const placeholder = document.getElementById('blog-placeholder'); const sectionsContainer = document.getElementById('blog-sections-container'); const saveBtn = document.getElementById('save-blog-changes-btn'); const cancelBtn = document.getElementById('cancel-blog-changes-btn'); let currentPageKey = null;
            async function loadBlogData(pageKey) { currentPageKey = pageKey; if (!pageKey) { editorContainer.style.display = 'none'; placeholder.style.display = 'block'; return; } editorContainer.style.display = 'block'; placeholder.style.display = 'none'; try { const response = await fetch(`api_blogs.php?action=fetch&page_key=${pageKey}`); const result = await response.json(); if (result.success) { populateBlogForm(result.data); } else { alert(`Error fetching data for ${pageKey}: ${result.message}`); } } catch (e) { console.error('Fetch error:', e); alert('A network error occurred.'); } }
            function populateBlogForm(data) { document.getElementById('blog-page-key-field').value = data.page_key; document.getElementById('blog-title').value = data.title || ''; document.getElementById('blog-author').value = data.author || ''; document.getElementById('blog-main-content').value = data.main_content || ''; document.getElementById('blog-main-image-file').value = ''; const mainImagePreview = document.getElementById('blog-main-image-preview'); if (data.main_image_path) { mainImagePreview.innerHTML = `<img src="../${data.main_image_path}" class="img-fluid rounded" alt="Main Image Preview">`; } else { mainImagePreview.innerHTML = '<p class="text-muted m-0">No main image set.</p>'; } sectionsContainer.innerHTML = ''; const template = document.getElementById('blog-section-template'); if (data.sections && data.sections.length > 0) { data.sections.forEach(section => { const clone = template.content.cloneNode(true); clone.querySelector('.blog-section-id-field').value = section.id; clone.querySelector('.blog-section-title-field').value = section.title || ''; clone.querySelector('.blog-section-content-field').value = section.content || ''; const imagePreview = clone.querySelector('.blog-section-image-preview'); if (section.image_path) { imagePreview.innerHTML = `<img src="../${section.image_path}" class="img-fluid rounded" alt="Section Image Preview">`; } else { imagePreview.innerHTML = '<p class="text-muted m-0">No image for this section.</p>'; } clone.querySelector('.blog-section-image-file-field').name = `section_image_file_${section.id}`; sectionsContainer.appendChild(clone); }); } }
            selector.addEventListener('change', () => loadBlogData(selector.value));
            document.addEventListener('change', function(event) { const target = event.target; const isMainBlogImage = target.id === 'blog-main-image-file'; const isSectionBlogImage = target.classList.contains('blog-section-image-file-field'); if (isMainBlogImage || isSectionBlogImage) { if (target.type === 'file' && target.files && target.files[0]) { const file = target.files[0]; let previewContainer; if (isMainBlogImage) { previewContainer = document.getElementById('blog-main-image-preview'); } else { previewContainer = target.closest('.blog-section-card').querySelector('.blog-section-image-preview'); } if (previewContainer) { const reader = new FileReader(); reader.onload = e => { previewContainer.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" alt="New Image Preview">`; }; reader.readAsDataURL(file); } } } });
            cancelBtn.addEventListener('click', () => { if (currentPageKey) { confirmationModalTitle.textContent = "Confirm Cancel"; confirmationModalBody.textContent = 'Are you sure you want to discard changes? This will reload the last saved content.'; confirmActionBtn.onclick = () => { loadBlogData(currentPageKey); confirmationModal.hide(); }; confirmationModal.show(); } });
            saveBtn.addEventListener('click', () => { confirmationModalTitle.textContent = "Confirm Save"; confirmationModalBody.textContent = 'Are you sure you want to save these changes to the blog page?'; confirmActionBtn.onclick = async () => { confirmationModal.hide(); const formData = new FormData(form); formData.append('action', 'update'); const sectionsData = []; document.querySelectorAll('#blog-sections-container .blog-section-card').forEach(card => { sectionsData.push({ id: card.querySelector('.blog-section-id-field').value, title: card.querySelector('.blog-section-title-field').value, content: card.querySelector('.blog-section-content-field').value, }); }); formData.append('sections', JSON.stringify(sectionsData)); try { const response = await fetch('api_blogs.php', { method: 'POST', body: formData }); const result = await response.json(); if (result.success) { showSuccessAlert('Blog page updated successfully!'); loadBlogData(currentPageKey); } else { alert('Error updating blog page: ' + result.message); } } catch (e) { alert('A critical error occurred while saving.'); console.error(e); } }; confirmationModal.show(); });
        })();
        
        // --- START: SCRIPT FOR PARTNERS PAGE MANAGEMENT ---
        (function() {
            let partnersData = [];
            let selectedPartnerId = null;
            const container = document.getElementById('partners-list-container');
            const addBtn = document.getElementById('add-partner-btn');
            const editBtn = document.getElementById('edit-partner-btn');
            const deleteBtn = document.getElementById('delete-partner-btn');
            const modalEl = document.getElementById('partnerModal');
            const partnerModal = new bootstrap.Modal(modalEl);
            const form = document.getElementById('partner-form');
            const saveBtn = document.getElementById('save-partner-btn');

            async function loadPartners() {
                try {
                    const response = await fetch('api_partners.php?action=fetch');
                    const result = await response.json();
                    if (result.success) {
                        partnersData = result.data;
                        renderPartners();
                    } else {
                        alert('Error fetching partners: ' + result.message);
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    alert('A network error occurred while fetching partners.');
                }
            }

            function renderPartners() {
                container.innerHTML = '';
                if (partnersData.length === 0) {
                    container.innerHTML = '<p class="text-center text-muted">No partners have been added yet.</p>';
                    return;
                }
                const template = document.getElementById('partner-card-template');
                partnersData.forEach(partner => {
                    const clone = template.content.cloneNode(true);
                    const card = clone.querySelector('.partner-card');
                    card.dataset.id = partner.id;

                    clone.querySelector('.bg-image-placeholder').src = partner.background_image_path ? `../${partner.background_image_path}` : 'https://placehold.co/600x400/e9ecef/6c757d?text=No+Image';
                    clone.querySelector('.logo-placeholder').src = partner.logo_path ? `../${partner.logo_path}` : 'https://placehold.co/100x100/ffffff/6c757d?text=Logo';
                    clone.querySelector('.partner-name-placeholder').textContent = partner.name;
                    const link = clone.querySelector('.partner-link-placeholder');
                    link.href = partner.website_link;
                    
                    // Prevent card selection when the link is clicked
                    link.addEventListener('click', (e) => e.stopPropagation());

                    if (parseInt(partner.id) === selectedPartnerId) {
                        card.classList.add('selected');
                    }
                    container.appendChild(clone);
                });
            }
            
            function updateFabState() {
                const isSelected = selectedPartnerId !== null;
                editBtn.disabled = !isSelected;
                deleteBtn.disabled = !isSelected;
            }

            function selectCard(partnerId) {
                selectedPartnerId = (selectedPartnerId === partnerId) ? null : partnerId;
                renderPartners();
                updateFabState();
            }
            
            container.addEventListener('click', e => {
                const card = e.target.closest('.partner-card');
                if (card && card.dataset.id) {
                    selectCard(parseInt(card.dataset.id));
                }
            });

            function prepareModal(mode = 'add', partner = null) {
                form.reset();
                document.getElementById('partnerId').value = '';
                document.getElementById('logo-preview').innerHTML = '';
                document.getElementById('bg-preview').innerHTML = '';
                form.classList.remove('was-validated');

                if (mode === 'add') {
                    document.getElementById('partnerModalLabel').textContent = 'Add New Partner';
                    saveBtn.textContent = 'Add Partner';
                } else if (mode === 'edit' && partner) {
                    document.getElementById('partnerModalLabel').textContent = `Edit Partner: ${partner.name}`;
                    saveBtn.textContent = 'Update Partner';
                    document.getElementById('partnerId').value = partner.id;
                    document.getElementById('partnerName').value = partner.name;
                    document.getElementById('partnerLink').value = partner.website_link;
                    if (partner.logo_path) {
                        document.getElementById('logo-preview').innerHTML = `<img src="../${partner.logo_path}" class="img-fluid rounded" style="max-height: 100px;">`;
                    }
                    if (partner.background_image_path) {
                        document.getElementById('bg-preview').innerHTML = `<img src="../${partner.background_image_path}" class="img-fluid rounded" style="max-height: 100px;">`;
                    }
                }
            }
            
            addBtn.addEventListener('click', () => {
                prepareModal('add');
                partnerModal.show();
            });

            editBtn.addEventListener('click', () => {
                if (selectedPartnerId === null) return;
                const partner = partnersData.find(p => p.id == selectedPartnerId);
                prepareModal('edit', partner);
                partnerModal.show();
            });

            saveBtn.addEventListener('click', async () => {
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                
                confirmationModalTitle.textContent = "Confirm Save";
                confirmationModalBody.textContent = 'Are you sure you want to save this partner?';
                
                confirmActionBtn.onclick = async () => {
                    confirmationModal.hide(); 
                    
                    const formData = new FormData(form);
                    const action = document.getElementById('partnerId').value ? 'update' : 'add';
                    formData.append('action', action);

                    try {
                        const response = await fetch('api_partners.php', { method: 'POST', body: formData });
                        const result = await response.json();
                        if (result.success) {
                            partnerModal.hide();
                            loadPartners();
                            showSuccessAlert('Partner saved successfully!');
                        } else {
                            alert('Error saving partner: ' + result.message);
                        }
                    } catch (error) {
                        console.error('Save error:', error);
                        alert('A network error occurred while saving the partner.');
                    }
                };
                
                confirmationModal.show();
            });

             deleteBtn.addEventListener('click', () => {
                if (selectedPartnerId === null) return;
                const partner = partnersData.find(p => p.id == selectedPartnerId);
                confirmationModalTitle.textContent = "Confirm Deletion";
                confirmationModalBody.innerHTML = `Are you sure you want to delete the partner: <strong>${partner.name}</strong>? This will also remove their images and cannot be undone.`;
                confirmActionBtn.onclick = async () => {
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id', selectedPartnerId);
                    const response = await fetch('api_partners.php', { method: 'POST', body: formData });
                    const result = await response.json();
                    if (result.success) {
                        selectedPartnerId = null;
                        updateFabState();
                        loadPartners();
                    } else {
                        alert('Error: ' + result.message);
                    }
                    confirmationModal.hide();
                };
                confirmationModal.show();
            });


            loadPartners();
        })();

        // --- START: SCRIPT FOR FOOTER PAGE MANAGEMENT ---
        (function() {
            const form = document.getElementById('footer-form');
            const saveBtn = document.getElementById('save-footer-changes-btn');
            const cancelBtn = document.getElementById('cancel-footer-changes-btn');
            const inputIds = [
                'footer-newsletter-title', 'footer-newsletter-text', 'footer-contact-email', 
                'footer-contact-phone', 'footer-contact-address', 'footer-facebook-url', 
                'footer-twitter-url', 'footer-instagram-url', 'footer-linkedin-url', 
                'footer-tiktok-url', 'footer-credits-text', 'footer-credits-year'
            ];

            async function loadFooterData() {
                try {
                    const response = await fetch('api_footer.php?action=fetch');
                    const result = await response.json();
                    if (result.success) {
                        populateFooterForm(result.data);
                    } else {
                        alert('Error fetching footer data: ' + result.message);
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    alert('A network error occurred while fetching footer data.');
                }
            }

            function populateFooterForm(data) {
                for (const key in data) {
                    const input = document.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = data[key];
                    }
                }
            }

            saveBtn.addEventListener('click', () => {
                 if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                confirmationModalTitle.textContent = "Confirm Save";
                confirmationModalBody.textContent = 'Are you sure you want to save all footer changes?';
                confirmActionBtn.onclick = async () => {
                    confirmationModal.hide();
                    
                    const footerData = {};
                    inputIds.forEach(id => {
                        const input = document.getElementById(id);
                        if(input) {
                           footerData[input.name] = input.value;
                        }
                    });

                    const formData = new FormData();
                    formData.append('action', 'update');
                    formData.append('footerData', JSON.stringify(footerData));

                    try {
                        const response = await fetch('api_footer.php', { method: 'POST', body: formData });
                        const result = await response.json();
                        if (result.success) {
                            showSuccessAlert('Footer content saved successfully!');
                        } else {
                            alert('Error saving footer: ' + result.message);
                        }
                    } catch (error) {
                        console.error('Save error:', error);
                        alert('A network error occurred while saving the footer.');
                    }
                };
                confirmationModal.show();
            });

            cancelBtn.addEventListener('click', () => {
                confirmationModalTitle.textContent = "Confirm Cancel";
                confirmationModalBody.textContent = 'Are you sure you want to discard changes? This will reload the last saved content.';
                confirmActionBtn.onclick = () => {
                    loadFooterData();
                    confirmationModal.hide();
                };
                confirmationModal.show();
            });

            // Initial load when the footer tab becomes active
            const footerTabObserver = new MutationObserver((mutations) => {
                for (const mutation of mutations) {
                    if (mutation.attributeName === 'class' && mutation.target.classList.contains('active')) {
                        loadFooterData();
                    }
                }
            });
            const footerSection = document.getElementById('footer');
            if(footerSection){
                footerTabObserver.observe(footerSection, { attributes: true });
            }


        })();

        // --- START: SCRIPT FOR NEWSLETTER SUBSCRIBERS ---
        (function() {
             async function loadSubscribers() {
                try {
                    const response = await fetch('api_newsletter.php?action=fetch');
                    const result = await response.json();
                    const tableBody = document.getElementById('subscriber-table-body');
                    tableBody.innerHTML = ''; // Clear existing rows
                    
                    if (result.success && result.data.length > 0) {
                        result.data.forEach((subscriber, index) => {
                            const row = tableBody.insertRow();
                            row.insertCell().textContent = index + 1;
                            row.insertCell().textContent = subscriber.email;
                            row.insertCell().textContent = new Date(subscriber.subscription_date).toLocaleDateString();
                        });
                    } else if (result.success) {
                         tableBody.innerHTML = '<tr><td colspan="3" class="text-center text-muted">No subscribers yet.</td></tr>';
                    } else {
                        alert('Error fetching subscribers: ' + result.message);
                    }
                } catch (error) {
                    console.error('Fetch subscribers error:', error);
                    alert('A network error occurred while fetching subscribers.');
                }
            }

            const newsletterTabObserver = new MutationObserver((mutations) => {
                for (const mutation of mutations) {
                    if (mutation.attributeName === 'class' && mutation.target.classList.contains('active')) {
                        loadSubscribers();
                    }
                }
            });
            const newsletterSection = document.getElementById('newsletter');
            if(newsletterSection){
                newsletterTabObserver.observe(newsletterSection, { attributes: true });
            }

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

