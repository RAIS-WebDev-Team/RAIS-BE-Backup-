<?php
// notifications.php - Page for users to view their notifications

session_start();
include_once '../config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../login.php");
    exit;
}

$userId = $_SESSION['id'];

// --- FETCH USER DATA ---
$stmt_user = $conn->prepare("SELECT firstName, dark_mode FROM users WHERE id = ?");
$stmt_user->bind_param("i", $userId);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();
$darkModeEnabled = $user ? (bool)$user['dark_mode'] : false;
$stmt_user->close();

// --- FETCH DYNAMIC NOTIFICATIONS ---
$notifications = [];
$sql_notifications = "SELECT id, message, type, link, is_read, created_at 
                      FROM notifications 
                      WHERE user_id = ? 
                      ORDER BY created_at DESC";
if($stmt_notifications = $conn->prepare($sql_notifications)) {
    $stmt_notifications->bind_param("i", $userId);
    $stmt_notifications->execute();
    $result_notifications = $stmt_notifications->get_result();
    while ($row = $result_notifications->fetch_assoc()) {
        $notifications[] = $row;
    }
    $stmt_notifications->close();
}
$conn->close();

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $weeks = floor($diff->d / 7);
    $days = $diff->d - ($weeks * 7);

    $intervals = [
        'y' => $diff->y, 'm' => $diff->m, 'w' => $weeks, 'd' => $days,
        'h' => $diff->h, 'i' => $diff->i, 's' => $diff->s,
    ];

    $string_map = [
        'y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day',
        'h' => 'hour', 'i' => 'minute', 's' => 'second',
    ];
    
    $result_parts = [];
    foreach ($string_map as $key => $label) {
        if ($intervals[$key] > 0) {
            $value = $intervals[$key];
            $result_parts[] = $value . ' ' . $label . ($value > 1 ? 's' : '');
        }
    }

    if (empty($result_parts)) { return 'just now'; }
    if (!$full) { $result_parts = array_slice($result_parts, 0, 1); }
    
    return implode(', ', $result_parts) . ' ago';
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAIS Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../img/logoulit.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
        body { font-family: 'Poppins', sans-serif; background-color: var(--rais-light-gray); color: var(--rais-text-dark); overflow: hidden; }
        .main-wrapper { display: flex; height: 100vh; }
        .sidebar { background-color: var(--rais-primary-green); width: 70px; flex-shrink: 0; color: white; padding: 30px 0; box-shadow: var(--rais-shadow); transition: width 0.3s ease-in-out; overflow: hidden; position: fixed; top: 0; height: 100vh; display: flex; flex-direction: column; z-index: 1031; }
        .sidebar:hover { width: 280px; }
        .sidebar .logo { font-size: 2.2rem; font-weight: 700; margin-bottom: 30px; text-align: center; letter-spacing: 1px; white-space: nowrap; opacity: 0; transition: opacity 0.3s ease-in-out; }
        .sidebar:hover .logo { opacity: 1; }
        .sidebar .nav { flex-grow: 1; }
        .sidebar .nav-link { color: white; font-weight: 500; padding: 15px 30px; display: flex; align-items: center; gap: 15px; white-space: nowrap; transition: background-color 0.3s ease; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background-color: var(--rais-dark-green); }
        .sidebar .nav-link i { font-size: 1.2rem; min-width: 20px; text-align: center; }
        .sidebar .nav-link span { opacity: 0; transition: opacity 0.1s ease-in-out 0.2s; }
        .sidebar:hover .nav-link span { opacity: 1; }
        .sidebar .footer-text { font-size: 0.8rem; color: #bbb; text-align: center; padding: 15px 0; opacity: 0; transition: opacity 0.3s ease-in-out; margin-top: auto; }
        .sidebar:hover .footer-text { opacity: 1; }
        .content-area { flex-grow: 1; height: 100vh; overflow-y: auto; margin-left: 70px; }
        .header { background-color: var(--rais-bg-light); height: 60px; display: flex; justify-content: space-between; align-items: center; padding: 0 25px; box-shadow: var(--rais-shadow); position: sticky; top: 0; z-index: 1020; }
        .header-brand { gap: 10px; }
        .header-logo-img { height: 100px; width: auto; object-fit: contain; }
        .header-title { font-size: 1rem; font-weight: 600; color: var(--rais-text-dark); white-space: nowrap; }
        .user-status { display: flex; align-items: center; gap: 10px; }
        .user-status .badge { background-color: var(--rais-button-maroon); font-size: 0.8rem; font-weight: 500; padding: 5px 15px; border-radius: 20px; }
        .user-status .btn { color: var(--rais-text-light); font-size: 1.5rem; padding: 0; }
        .power-btn i { color: #dc3545; }
        .power-btn:hover i { color: #a71d2a; }
        .main-content { flex-grow: 1; padding: 30px; animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .main-content h1 { font-size: 2rem; font-weight: 700; margin-bottom: 20px; }
        .notification-item { background-color: var(--rais-card-bg); border-radius: 12px; padding: 15px; box-shadow: var(--rais-shadow); margin-bottom: 10px; transition: transform 0.2s, box-shadow 0.2s; }
        .notification-link:hover .notification-item { transform: translateY(-5px); box-shadow: 0 8px 15px rgba(0,0,0,0.07); }
        .notification-item.read { opacity: 0.7; }
        .notification-title { font-weight: 600; margin-bottom: 5px; }
        .notification-date { font-size: 0.8rem; color: var(--rais-text-light); }
        .notification-icon { font-size: 1.5rem; width: 60px; text-align: center; }
        .notification-image { width: 100px; height: 60px; object-fit: cover; border-radius: 8px; }
        .notification-item.status-approved .notification-icon { color: var(--rais-primary-green); }
        .notification-item.status-cancelled .notification-icon { color: #dc3545; }
        .dark-mode-logo { display: none; }
        .dark-mode .light-mode-logo { display: none; }
        .dark-mode .dark-mode-logo { display: block; }
        body.dark-mode { background-color: #121212; color: #EAEAEA; }
        .dark-mode .sidebar { background-color: #1a1a1a; border-right: 1px solid #2c2c2c; }
        .dark-mode .header, .dark-mode .notification-item, .dark-mode .modal-content { background-color: #1e1e1e; color: #EAEAEA; border-color: #2c2c2c; }
        .dark-mode .modal-header, .dark-mode .modal-footer { border-color: #2c2c2c; }
        .dark-mode .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        .dark-mode .header { box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); }
        .dark-mode .header-title, .dark-mode h1, .dark-mode h6, .dark-mode .user-status .me-3 { color: #EAEAEA !important; }
        .dark-mode .notification-link { color: #EAEAEA !important; }
        .dark-mode .text-muted, .dark-mode .notification-date { color: #B0B0B0 !important; }
        .dark-mode .notification-link:hover .notification-item { box-shadow: 0 8px 15px rgba(0,0,0,0.2); }
        @media (max-width: 992px) {
            body { padding-top: 60px; padding-bottom: 50px; overflow: auto; }
            .main-wrapper { flex-direction: column; height: auto; }
            .content-area { height: auto; overflow-y: visible; margin-left: 0; }
            .header { position: fixed; top: 0; left: 0; right: 0; z-index: 1030; }
            .header-title { display: none; }
            .main-content { padding-top: 15px; }
            .sidebar { width: 100%; height: 50px; position: fixed; top: auto; bottom: 0; left: 0; z-index: 1029; flex-direction: row; align-items: center; padding: 0; transition: none; overflow-x: auto; overflow-y: hidden; }
            .sidebar:hover { width: 100%; }
            .sidebar .logo, .sidebar .footer-text { display: none; }
            .sidebar .nav { display: flex; flex-direction: row; align-items: center; height: 100%; width: 100%; justify-content: space-around; }
            .sidebar .nav-link { flex: 1; justify-content: center; align-items: center; padding: 0 5px; gap: 0; height: 100%; }
            .sidebar .nav-link:hover { background-color: var(--rais-dark-green); }
            .sidebar .nav-link i { font-size: 1.5rem; margin-bottom: 0; }
            .sidebar .nav-link span, .sidebar:hover .nav-link span { display: none; }
        }
    </style>
</head>

<body class="<?php echo $darkModeEnabled ? 'dark-mode' : ''; ?>">
    <div class="main-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar d-flex flex-column">
            <div class="logo">RAIS</div>
            <nav class="nav flex-column">
                <a class="nav-link" href="dashboard.php"><i class="bi bi-house-door-fill"></i><span>Dashboard</span></a>
                <a class="nav-link" href="book-consultation.php"><i class="bi bi-calendar-check"></i><span>Book Consultation</span></a>
                <a class="nav-link" href="statement-of-account.php"><i class="bi bi-receipt"></i><span>Statement of Account</span></a>
                <a class="nav-link" href="documents.php"><i class="bi bi-file-earmark-text"></i><span>Documents</span></a>
                <a class="nav-link" href="forms.php"><i class="bi bi-journal-text"></i><span>Forms</span></a>
                <a class="nav-link active" href="notifications.php"><i class="bi bi-bell"></i><span>Notifications</span></a>
                <a class="nav-link" href="settings.php"><i class="bi bi-gear"></i><span>Settings</span></a>
                <a class="nav-link" href="profile.php"><i class="bi bi-person-circle"></i><span>Profile</span></a>
            </nav>
            <div class="mt-auto footer-text">&copy; <?php echo date("Y"); ?> RAIS</div>
        </aside>

        <!-- Main Content Area -->
        <div class="content-area">
            <!-- Header -->
            <div class="header">
                <div class="header-brand d-flex align-items-center">
                    <img src="../img/logo.png" alt="RAIS Logo" class="header-logo-img light-mode-logo">
                    <img src="../img/logo1.png" alt="RAIS Logo Dark" class="header-logo-img dark-mode-logo" onerror="this.style.display='none'">
                    <span class="header-title">Roman & Associates Immigration Services</span>
                </div>
                <div class="user-status d-flex align-items-center gap-2">
                    <div id="headerDate" class="me-3" style="font-weight: 500;"></div>
                    <a href="#" class="btn btn-link power-btn" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="bi bi-power"></i></a>
                    <span class="badge"><?php echo htmlspecialchars($user['firstName']); ?></span>
                </div>
            </div>

            <!-- Main Content -->
            <main class="main-content">
                <h1>Notifications</h1>
                <div class="row g-3">
                    <?php if (empty($notifications)): ?>
                        <div class="col-12">
                            <div class="notification-item text-center">
                                <p class="mb-0 text-muted">You have no new notifications.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($notifications as $notif): ?>
                        <div class="col-12">
                            <a href="<?php echo htmlspecialchars($notif['link'] ?? '#'); ?>" class="text-decoration-none text-dark notification-link">
                                <div class="notification-item <?php echo $notif['is_read'] ? 'read' : ''; ?> <?php echo (strpos($notif['message'], 'Approved') !== false) ? 'status-approved' : ((strpos($notif['message'], 'Cancelled') !== false) ? 'status-cancelled' : ''); ?>">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="notification-icon">
                                            <?php if (strpos($notif['message'], 'Approved') !== false): ?>
                                                <i class="bi bi-check-circle-fill"></i>
                                            <?php elseif (strpos($notif['message'], 'Cancelled') !== false): ?>
                                                <i class="bi bi-x-circle-fill"></i>
                                            <?php else: // Pending ?>
                                                <i class="bi bi-clock-history"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <p class="mb-0"><?php echo htmlspecialchars($notif['message']); ?></p>
                                        </div>
                                        <div class="ms-auto text-end">
                                            <small class="notification-date dynamic-timestamp" data-timestamp="<?php echo htmlspecialchars($notif['created_at']); ?>"><?php echo time_elapsed_string($notif['created_at']); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                     <!-- Static Notifications for Blogs -->
                    <div class="col-12"><hr></div>
                    <div class="col-12">
                        <a href="../blog/canada.php" class="text-decoration-none text-dark notification-link">
                            <div class="notification-item">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="../blog/img/canada.png" alt="Blog Post Image" class="notification-image">
                                    <div>
                                        <h6 class="notification-title">New Blog Post: A Long Road for "A Calling to Canada"</h6>
                                        <p class="mb-0 text-muted">A new blog post about the upcoming event has been published.</p>
                                    </div>
                                    <div class="ms-auto text-end"><small class="notification-date">April 12, 2025</small></div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-12">
                        <a href="../blog/mini-fair.php" class="text-decoration-none text-dark notification-link">
                            <div class="notification-item">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="../blog/img/minifair2.png" alt="Event Image" class="notification-image">
                                    <div>
                                        <h6 class="notification-title">Event Update: IELTS Mini Fair</h6>
                                        <p class="mb-0 text-muted">The date RAIS became partners of IELTS, March 29, 2025.</p>
                                    </div>
                                    <div class="ms-auto text-end"><small class="notification-date">March 29, 2025</small></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="../blog/calamba.php" class="text-decoration-none text-dark notification-link">
                            <div class="notification-item ">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="../blog/img/calamba.png" alt="Blog Post Image" class="notification-image">
                                    <div>
                                        <h6 class="notification-title ">New Blog Post: Visit to Laguna</h6>
                                        <p class="mb-0 text-muted">Read about our team's recent visit to Calamba, Laguna.</p>
                                    </div>
                                    <div class="ms-auto text-end"><small class="notification-date">May 10, 2025</small></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="../blog/la-salle.php" class="text-decoration-none text-dark notification-link">
                            <div class="notification-item">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="../blog/img/lasalle.png" alt="Event Image" class="notification-image">
                                    <div>
                                        <h6 class="notification-title">Event: Academic Partner Visits</h6>
                                        <p class="mb-0 text-muted">De La Salle Lipa advisers are visiting Roman & Associates.</p>
                                    </div>
                                    <div class="ms-auto text-end"><small class="notification-date">March 27, 2025</small></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header"><h5 class="modal-title">Confirm Logout</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
          <div class="modal-body">Are you sure you want to log out?</div>
          <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><a href="../logout.php" class="btn btn-danger">Logout</a></div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('headerDate').textContent = new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            
            function timeElapsedString(datetime) {
                const now = new Date();
                const ago = new Date(datetime);
                const diffInSeconds = Math.floor((now - ago) / 1000);

                if (diffInSeconds < 5) return 'just now';

                const intervals = {
                    year: 31536000,
                    month: 2592000,
                    week: 604800,
                    day: 86400,
                    hour: 3600,
                    minute: 60,
                    second: 1
                };

                for (const intervalName in intervals) {
                    const intervalSeconds = intervals[intervalName];
                    const counter = Math.floor(diffInSeconds / intervalSeconds);
                    if (counter > 0) {
                        return `${counter} ${intervalName}${counter > 1 ? 's' : ''} ago`;
                    }
                }
                return 'just now';
            }

            function updateTimestamps() {
                const timestampElements = document.querySelectorAll('.dynamic-timestamp');
                timestampElements.forEach(el => {
                    const timestamp = el.dataset.timestamp;
                    if (timestamp) {
                        el.textContent = timeElapsedString(timestamp);
                    }
                });
            }

            // Update timestamps immediately on load
            updateTimestamps();

            // And then update every 30 seconds
            setInterval(updateTimestamps, 30000);
        });
    </script>
</body>
</html>

