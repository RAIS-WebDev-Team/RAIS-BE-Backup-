<?php
// -----------------------------------------------------------------
// File: reset-password.php (New File)
// This page displays the form for the user to enter a new password.
// It's linked to from the email.
// -----------------------------------------------------------------

// --- Get the token from the URL query string ---
$token = $_GET["token"] ?? null;

if ($token === null) {
    die("Token not found. Please use the link from your email.");
}

// --- Hash the token from the URL to match the one in the database ---
$token_hash = hash("sha256", $token);

// --- Include database connection ---
require_once 'db_connect.php';

// --- Find the user record associated with this token hash ---
$sql = "SELECT * FROM users WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// --- If no user is found, the token is invalid ---
if ($user === null) {
    die("Token not found or invalid. It may have already been used.");
}

// --- Check if the token has expired ---
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired. Please request a new reset link from the forgot password page.");
}

$page_title = "RAIS Create - Reset Password";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .video-bg { position: fixed; top: 0; left: 0; min-width: 100%; min-height: 100%; object-fit: cover; z-index: -2; filter: blur(2px) brightness(0.8); }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: -1; }
        .form-container { background: rgba(0, 4, 4, 0.25); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.18); border-radius: 20px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); max-width: 500px; width: 100%; padding: 3rem; }
        .form-control { border: none; border-radius: 10px; background-color: rgba(255, 255, 255, 0.2); color: white; }
        .form-floating > label { color: #ddd; }
        .form-control::placeholder { color: #ddd; }
        .form-control:focus { background-color: rgba(255, 255, 255, 0.3); box-shadow: 0 0 0 0.25rem rgba(12, 71, 12, 0.5); border-color: #106210; color: white; }
        .form-floating > .form-control:focus ~ label { color: #a5d6a7; }
        .btn-custom { background-color: #0C470C; border-radius: 25px; padding: 10px 25px; border: none; }
        .btn-custom:hover { background-color: #106210; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100 p-3">
    <video autoplay muted loop class="video-bg">
        <source src="vids/canadaaa.mp4" type="video/mp4">
    </video>
    <div class="overlay"></div>
    <main class="form-container text-white text-center">
        <h2 class="mb-3 fs-2 fw-bold">Reset Password</h2>
        <p class="mb-4">Enter your new password below.</p>
        <form method="POST" action="process-reset-password.php">
            <!-- Hidden input to securely pass the token to the next script -->
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="New password" required>
                <label for="password">New password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                <label for="password_confirmation">Confirm new password</label>
            </div>
            <button type="submit" class="btn btn-custom text-white mt-3 fw-bold">Reset Password</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
