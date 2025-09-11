<?php
session_start();
require_once '../config.php';

// Security Check: Ensure user is logged in and is a Super Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'Super Admin') {
    header("Location: ../login.php");
    exit;
}

$page_title = "RAIS Admin - Authorize Admin Access";
$active_page = "authorize_admin"; // You can add this to your sidebar logic
$super_admin_id = $_SESSION['id'];

// Handle approval/denial actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'], $_POST['action'])) {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];
    $status = ($action === 'approve') ? 'approved' : 'denied';

    $stmt = $conn->prepare("UPDATE admin_access_requests SET status = ?, authorized_by_superadmin_id = ?, authorized_at = NOW() WHERE id = ? AND status = 'pending'");
    $stmt->bind_param("sii", $status, $super_admin_id, $request_id);
    $stmt->execute();
    $stmt->close();

    header("Location: authorize_admin.php");
    exit;
}

// Fetch pending requests
$pending_requests = [];
$sql = "SELECT r.id, r.requested_at, u.firstName, u.lastName, u.email 
        FROM admin_access_requests r
        JOIN users u ON r.admin_user_id = u.id
        WHERE r.status = 'pending'
        ORDER BY r.requested_at ASC";

if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $pending_requests[] = $row;
    }
    $result->free();
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
</head>

<body>
    <div class="main-wrapper">
        <?php require_once 'sidebar.php'; ?>
        <div class="content-area">
            <?php require_once 'header.php'; ?>
            <main class="main-content">
                <h1>Authorize Admin Access</h1>
                <div class="content-card">
                    <h2>Pending Access Requests</h2>
                    <?php if (empty($pending_requests)) : ?>
                        <div class="alert alert-success mt-3" role="alert">
                            There are no pending access requests at this time.
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
                                                <form method="POST" action="authorize_admin.php" class="d-inline">
                                                    <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                                    <button type="submit" name="action" value="approve" class="btn btn-sm btn-success"><i class="bi bi-check-circle-fill me-1"></i>Approve</button>
                                                </form>
                                                <form method="POST" action="authorize_admin.php" class="d-inline">
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
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>
</body>
</html>
