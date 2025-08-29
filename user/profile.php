<?php
// profile.php - User's profile page

// Start the session to access logged-in user's data.
session_start();

// Include the database configuration file.
include_once '../config.php';

// Check if the user is logged in. If not, redirect them to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../login.php");
    exit;
}

// Get the logged-in user's ID from the session.
$userId = $_SESSION['id'];

// --- FETCH USER DATA AND SETTINGS FROM DATABASE ---
$stmt = $conn->prepare("SELECT firstName, lastName, email, phone, address, birthday, profileImage, facebook, instagram, gmail, dark_mode FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userProfile = $result->fetch_assoc();
$stmt->close();
$conn->close();

// If no user is found, redirect or show an error.
if (!$userProfile) {
    echo "User not found.";
    exit;
}
$darkModeEnabled = (bool)$userProfile['dark_mode'];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAIS Profile</title>
    <link rel="icon" href="../img/logoulit.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --rais-primary-green: #004d40;
            --rais-dark-green: #00332c;
            --rais-text-dark: #333333;
            --rais-text-light: #525252;
            --rais-card-bg: #FFFFFF;
            --rais-light-gray: #E8E8E8;
            --rais-bg-light: #F7F7F7;
            --rais-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            --rais-button-maroon: #811F1D;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--rais-light-gray);
            overflow: hidden;
        }
        .main-wrapper { display: flex; height: 100vh; }
        .sidebar {
            background-color: var(--rais-primary-green);
            width: 70px;
            flex-shrink: 0;
            color: white;
            padding: 30px 0;
            box-shadow: var(--rais-shadow);
            transition: width 0.3s ease-in-out;
            overflow: hidden;
            position: fixed;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 1031;
        }
        .sidebar:hover { width: 280px; }
        .sidebar .logo {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 1px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .sidebar:hover .logo {
            opacity: 1;
        }
        .sidebar .nav {
            flex-grow: 1;
        }
        .sidebar .nav-link {
            color: white;
            font-weight: 500;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            white-space: nowrap;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background-color: var(--rais-dark-green); }
        .sidebar .nav-link i { font-size: 1.2rem; min-width: 20px; text-align: center; }
        .sidebar .nav-link span { opacity: 0; transition: opacity 0.1s ease-in-out 0.2s; }
        .sidebar:hover .nav-link span { opacity: 1; }
        .sidebar .footer-text {
            font-size: 0.8rem;
            color: #bbb;
            text-align: center;
            padding: 15px 0;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            margin-top: auto;
        }

        .sidebar:hover .footer-text {
            opacity: 1;
        }
        .content-area { flex-grow: 1; height: 100vh; overflow-y: auto; margin-left: 70px; }
        .header {
            background-color: var(--rais-bg-light);
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            position: sticky; top: 0; z-index: 1020;
            box-shadow: var(--rais-shadow);
        }
        .header-brand {
            gap: 10px;
        }
        .header-logo-img { 
            height: 100px;
            width: auto;
            object-fit: contain;
        }
        .header-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--rais-text-dark);
            white-space: nowrap;
        }
        .user-status {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-status .badge {
            background-color: var(--rais-button-maroon);
            font-size: 0.8rem;
            font-weight: 500;
            padding: 5px 15px;
            border-radius: 20px;
        }
        .user-status .btn {
            color: var(--rais-text-light);
            font-size: 1.5rem;
            padding: 0;
        }
        .power-btn i {
            color: #dc3545;
            transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
        }
        .power-btn:hover i {
            color: #a71d2a;
            transform: scale(1.1);
        }
        .main-content { padding: 30px; }
        .content-card {
            background-color: var(--rais-card-bg);
            border-radius: 12px;
            padding: 30px;
        }
        .profile-image, .profile-image-preview {
            width: 100px; 
            height: 100px; 
            object-fit: cover; 
            border-radius: 50%;
        }
         .profile-view .profile-icon {
            font-size: 100px;
            color: var(--rais-primary-green);
        }
        #profile-edit-form { 
            display: none; /* Hide the edit form by default */
        }

        .floating-btn {
            position: fixed; bottom: 30px; right: 30px;
            background-color: var(--rais-button-maroon); color: white;
            border-radius: 50%; width: 60px; height: 60px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none; transition: background-color 0.2s;
            z-index: 100;
        }
        .floating-btn:hover { background-color: var(--rais-dark-green); }

        .chat-container {
            position: fixed; bottom: 100px; right: 30px; width: 350px;
            max-height: 500px; background-color: white; border-radius: 12px;
            box-shadow: var(--rais-shadow); display: flex; flex-direction: column;
            z-index: 99; transform: translateY(100%); opacity: 0; visibility: hidden;
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        .chat-container.show { transform: translateY(0); opacity: 1; visibility: visible; }
        .chat-header {
            background-color: var(--rais-primary-green); color: white; padding: 1rem;
            border-top-left-radius: 12px; border-top-right-radius: 12px; cursor: pointer;
        }
        .chat-body {
            padding: 1rem; flex-grow: 1; overflow-y: auto;
            background-color: var(--rais-bg-light); display: flex;
            flex-direction: column-reverse; height: 350px;
        }
        .chat-footer { padding: 1rem; border-top: 1px solid var(--rais-light-gray); }
        
        .chat-footer .btn i, .chat-footer-fullscreen .btn i {
            color: var(--rais-text-dark);
        }

        .chat-toggle-btn {
            position: fixed; bottom: 30px; right: 100px;
            background-color: var(--rais-button-maroon); color: white;
            border-radius: 50%; width: 60px; height: 60px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer; z-index: 100;
        }
        #full-screen-chat {
            position: fixed; top: 0; left: 0; width: 100%; height: 100vh;
            background-color: var(--rais-bg-light); z-index: 2000;
            display: none; flex-direction: column;
        }
        .chat-header-fullscreen {
            display: flex; align-items: center; padding: 1rem;
            background-color: var(--rais-primary-green); color: white; flex-shrink: 0;
        }
        .back-btn {
            background: none; border: none; color: white;
            font-size: 1.5rem; cursor: pointer; margin-right: 1rem;
        }
        .chat-title-fullscreen { font-weight: 600; font-size: 1.2rem; }
        .chat-body-fullscreen {
            flex-grow: 1; overflow-y: auto; padding: 1rem;
            display: flex; flex-direction: column-reverse;
        }
        .chat-footer-fullscreen {
            padding: 1rem; border-top: 1px solid var(--rais-light-gray);
            background-color: white; flex-shrink: 0;
        }

        /* Dark Mode Styles */
        .dark-mode-logo { display: none; }
        .dark-mode .light-mode-logo { display: none; }
        .dark-mode .dark-mode-logo { display: block; }
        body.dark-mode { background-color: #121212; color: #EAEAEA; }
        .dark-mode .sidebar { background-color: #1a1a1a; border-right: 1px solid #2c2c2c; }
        .dark-mode .header, .dark-mode .content-card, .dark-mode .modal-content, .dark-mode .chat-container, .dark-mode #full-screen-chat, .dark-mode .chat-footer-fullscreen { background-color: #1e1e1e; color: #EAEAEA; border-color: #2c2c2c; }
        .dark-mode .header { box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); }
        .dark-mode .header-title, .dark-mode h1, .dark-mode h5, .dark-mode .user-status .me-3, .dark-mode p, .dark-mode .chat-title-fullscreen { color: #EAEAEA !important; }
        .dark-mode .form-control { background-color: #2a2a2a; color: #EAEAEA; border-color: #3c3c3c; }
        .dark-mode .form-control:focus { background-color: #2a2a2a; color: #EAEAEA; border-color: var(--rais-primary-green); box-shadow: 0 0 0 0.25rem rgba(0, 77, 64, 0.5); }
        .dark-mode a { color: #4db6ac; }
        .dark-mode a:hover { color: #81c784; }
        .dark-mode hr { border-top-color: #3c3c3c; }
        .dark-mode .chat-body {
            background-color: #121212;
        }
        .dark-mode .chat-body .text-muted, .dark-mode .chat-body-fullscreen .text-muted {
            color: #EAEAEA !important;
        }
        .dark-mode .form-control::placeholder {
            color: #888;
        }
        .dark-mode .chat-footer .btn i, .dark-mode .chat-footer-fullscreen .btn i {
            color: #EAEAEA;
        }
        .dark-mode .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            body { padding-top: 60px; padding-bottom: 50px; overflow: auto; }
            .content-area { margin-left: 0; }
            .header { position: fixed; top: 0; left: 0; right: 0; z-index: 1030; }
            .header-title { display: none; }
            .main-content { padding-top: 15px; }
            .sidebar {
                width: 100%; height: 50px; position: fixed; top: auto; bottom: 0; left: 0;
                z-index: 1029; flex-direction: row; 
                align-items: center; padding: 0; transition: none;
                overflow-x: auto; overflow-y: hidden;
            }
            .sidebar:hover { width: 100%; }
            .sidebar .logo, .sidebar .footer-text { display: none; }
            .sidebar .nav {
                display: flex;
                flex-direction: row;
                align-items: center;
                height: 100%;
                width: 100%;
                justify-content: space-around;
            }

            .sidebar .nav-link {
                flex: 1;
                justify-content: center;
                align-items: center;
                padding: 0 5px;
                gap: 0;
                height: 100%;
            }

            .sidebar .nav-link:hover {
                background-color: var(--rais-dark-green);
            }

            .sidebar .nav-link i {
                font-size: 1.5rem;
                margin-bottom: 0;
            }

            .sidebar .nav-link span,
            .sidebar:hover .nav-link span {
                display: none;
            }
            .floating-btn { bottom: 80px; right: 15px; }
            .chat-toggle-btn { bottom: 80px; right: 85px; }
            .chat-container { display: none !important; }
        }
    </style>
</head>
<body class="<?php echo $darkModeEnabled ? 'dark-mode' : ''; ?>">
    <div class="main-wrapper">
        <aside class="sidebar d-flex flex-column">
            <div class="logo">RAIS</div>
              <nav class="nav flex-column">
                  <a class="nav-link" href="dashboard.php"><i class="bi bi-house-door-fill"></i><span>Dashboard</span></a>
                  <a class="nav-link" href="book-consultation.php"><i class="bi bi-calendar-check"></i><span>Book Consultation</span></a>
                  <a class="nav-link" href="statement-of-account.php"><i class="bi bi-receipt"></i><span>Statement of Account</span></a>
                  <a class="nav-link" href="documents.php"><i class="bi bi-file-earmark-text"></i><span>Documents</span></a>
                  <a class="nav-link" href="forms.php"><i class="bi bi-journal-text"></i><span>Forms</span></a>
                  <a class="nav-link" href="notifications.php"><i class="bi bi-bell"></i><span>Notifications</span></a>
                  <a class="nav-link" href="settings.php"><i class="bi bi-gear"></i><span>Settings</span></a>
                  <a class="nav-link active" href="profile.php"><i class="bi bi-person-circle"></i><span>Profile</span></a>
              </nav>
            <div class="mt-auto footer-text">
                &copy; <?php echo date("Y"); ?> RAIS
            </div>
        </aside>

        <div class="content-area">
            <header class="header">
                <div class="header-brand d-flex align-items-center">
                    <img src="../img/logo.png" alt="RAIS Logo" class="header-logo-img light-mode-logo">
                    <img src="../img/logo1.png" alt="RAIS Logo Dark" class="header-logo-img dark-mode-logo" onerror="this.style.display='none'">
                    <span class="header-title">Roman & Associates Immigration Services</span>
                </div>
                <div class="user-status d-flex align-items-center gap-2">
                    <div class="me-3" style="font-weight: 500;"><?= date('F j, Y') ?></div>
                    <a href="#" class="btn btn-link power-btn" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="bi bi-power"></i></a>
                    <span class="badge"><?php echo htmlspecialchars($userProfile['firstName']); ?></span>
                </div>
            </header>

            <main class="main-content">
                <h1>Profile</h1>
                <div class="content-card">
                    <!-- Profile View Section -->
                    <div id="profile-view" class="profile-view text-center">
                        <div id="profileViewImageContainer">
                            <?php if (!empty($userProfile['profileImage'])): ?>
                                <img src="../<?php echo htmlspecialchars($userProfile['profileImage']); ?>?v=<?php echo time(); ?>" alt="Profile Image" class="profile-image">
                            <?php else: ?>
                                <i class="bi bi-person-circle profile-icon"></i>
                            <?php endif; ?>
                        </div>
                        <h5 class="mt-3"><?php echo htmlspecialchars($userProfile['firstName'] . ' ' . $userProfile['lastName']); ?></h5>
                        <hr>
                        <div class="text-start">
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($userProfile['email']); ?></p>
                            <p><strong>Contact:</strong> <?php echo htmlspecialchars($userProfile['phone']); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($userProfile['address']); ?></p>
                            <p><strong>Birthday:</strong> <?php echo htmlspecialchars(date("F j, Y", strtotime($userProfile['birthday']))); ?></p>
                            <?php if (!empty($userProfile['facebook'])): ?>
                                <p><strong>Facebook:</strong> <a href="<?php echo htmlspecialchars($userProfile['facebook']); ?>" target="_blank"><?php echo htmlspecialchars($userProfile['facebook']); ?></a></p>
                            <?php endif; ?>
                            <?php if (!empty($userProfile['instagram'])): ?>
                                <p><strong>Instagram:</strong> <a href="<?php echo htmlspecialchars($userProfile['instagram']); ?>" target="_blank"><?php echo htmlspecialchars($userProfile['instagram']); ?></a></p>
                            <?php endif; ?>
                            <?php if (!empty($userProfile['gmail'])): ?>
                                <p><strong>Gmail:</strong> <a href="mailto:<?php echo htmlspecialchars($userProfile['gmail']); ?>"><?php echo htmlspecialchars($userProfile['gmail']); ?></a></p>
                            <?php endif; ?>
                        </div>
                        <button id="editProfileBtn" class="btn btn-primary mt-4" style="background-color: var(--rais-button-maroon); border: none;">Edit Profile</button>
                    </div>

                    <!-- Profile Edit Form (Initially Hidden) -->
                    <form id="profile-edit-form" action="update-profile.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3 text-center">
                            <img id="profileImagePreview" src="<?php echo !empty($userProfile['profileImage']) ? '../' . htmlspecialchars($userProfile['profileImage']) . '?v=' . time() : 'https://placehold.co/100x100'; ?>" alt="Profile Preview" class="profile-image-preview mb-2">
                            <input class="form-control" type="file" name="profileImage" id="profileImageUpload">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($userProfile['firstName']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($userProfile['lastName']); ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Contact Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($userProfile['phone']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Location</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($userProfile['address']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">Birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($userProfile['birthday']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="facebook" class="form-label">Facebook Profile URL</label>
                            <input type="url" class="form-control" id="facebook" name="facebook" value="<?php echo htmlspecialchars($userProfile['facebook']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="instagram" class="form-label">Instagram Profile URL</label>
                            <input type="url" class="form-control" id="instagram" name="instagram" value="<?php echo htmlspecialchars($userProfile['instagram']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="gmail" class="form-label">Gmail Address</label>
                            <input type="email" class="form-control" id="gmail" name="gmail" value="<?php echo htmlspecialchars($userProfile['gmail']); ?>">
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="button" id="cancelEditBtn" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary" style="background-color: var(--rais-button-maroon); border: none;">Save Changes</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Floating Action Button -->
    <a href="book-flight.php" class="floating-btn text-decoration-none">
        <i class="bi bi-plus-lg"></i>
    </a>

    <!-- Collapsible Chatbox -->
    <div class="chat-container" id="chatContainer">
        <div class="chat-header d-flex justify-content-between align-items-center" onclick="toggleChat()">
            <h5 class="chat-modal-title mb-0"><i class="bi bi-chat-dots-fill me-2"></i>Live Chat</h5>
            <i class="bi bi-x-lg text-white"></i>
        </div>
        <div class="chat-body">
            <div class="text-center text-muted">RAIS Support how may i assist you?</div>
        </div>
        <div class="chat-footer">
            <div class="input-group">
                <input type="text" class="form-control message-input" placeholder="Type a message..."
                    aria-label="Message input">
                <button class="btn btn-outline-secondary" type="button" id="send-button-popup">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Full Screen Chat for Mobile -->
    <div id="full-screen-chat">
        <div class="chat-header-fullscreen">
            <button class="back-btn" id="backToDashboardBtn"><i class="bi bi-arrow-left"></i></button>
            <span class="chat-title-fullscreen"><i class="bi bi-chat-dots-fill me-2"></i>Live Chat</span>
        </div>
        <div class="chat-body-fullscreen">
            <div class="text-center text-muted">RAIS Support, how may I help you?</div>
        </div>
        <div class="chat-footer-fullscreen">
            <div class="input-group">
                <input type="text" class="form-control message-input" placeholder="Type a message..."
                    aria-label="Message input">
                <button class="btn btn-outline-secondary" type="button" id="send-button-fullscreen">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Floating Chat Toggle Button -->
    <button class="chat-toggle-btn" onclick="toggleChat()">
        <i class="bi bi-chat-dots"></i>
    </button>
    
    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to log out?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Added Bootstrap JS Bundle for modal functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editProfileBtn = document.getElementById('editProfileBtn');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            const profileView = document.getElementById('profile-view');
            const profileEditForm = document.getElementById('profile-edit-form');
            
            // Show edit form when "Edit Profile" is clicked
            editProfileBtn.addEventListener('click', function () {
                profileView.style.display = 'none';
                profileEditForm.style.display = 'block';
            });

            // Hide edit form when "Cancel" is clicked
            cancelEditBtn.addEventListener('click', function() {
                profileEditForm.style.display = 'none';
                profileView.style.display = 'block';
            });

            // Preview profile image before upload
            document.getElementById('profileImageUpload').addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('profileImagePreview').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });

            const mainWrapper = document.querySelector('.main-wrapper');
            const floatingBtn = document.querySelector('.floating-btn');
            const chatToggleBtn = document.querySelector('.chat-toggle-btn');
            const popupChatContainer = document.getElementById('chatContainer');
            const fullScreenChat = document.getElementById('full-screen-chat');

            window.toggleChat = function() {
                if (window.innerWidth <= 992) {
                    const isChatVisible = fullScreenChat.style.display === 'flex';
                    if (isChatVisible) {
                        fullScreenChat.style.display = 'none';
                        mainWrapper.style.display = 'flex';
                        if(floatingBtn) floatingBtn.style.display = 'flex';
                        if(chatToggleBtn) chatToggleBtn.style.display = 'flex';
                    } else {
                        fullScreenChat.style.display = 'flex';
                        mainWrapper.style.display = 'none';
                        if(floatingBtn) floatingBtn.style.display = 'none';
                        if(chatToggleBtn) chatToggleBtn.style.display = 'none';
                    }
                } else {
                    popupChatContainer.classList.toggle('show');
                }
            }
            
            if(document.getElementById('backToDashboardBtn')) {
                document.getElementById('backToDashboardBtn').addEventListener('click', toggleChat);
            }
        });
    </script>
</body>
</html>

