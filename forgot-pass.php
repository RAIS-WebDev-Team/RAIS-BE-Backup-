<?php
// -----------------------------------------------------------------
// File: forgot-password.php
// This file displays the form and handles the request to send a reset link.
// -----------------------------------------------------------------

// --- Use PHPMailer classes for sending email ---
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// --- Include the PHPMailer files manually ---
// This assumes the PHPMailer folder is inside the 'admin' directory
require 'admin/PHPMailer/Exception.php';
require 'admin/PHPMailer/PHPMailer.php';
require 'admin/PHPMailer/SMTP.php';

// --- IMPORTANT: CONFIGURE YOUR WEBSITE'S URL ---
// Replace 'http://your-domain.com' with the actual URL of your live website.
define('BASE_URL', 'http://your-domain.com');

// --- Page title and user feedback variables ---
$page_title = "RAIS Create - Forgot Password";
$message = ""; // To store user feedback (e.g., "Message sent")
$message_type = ""; // To control alert color ("success" or "danger")

// --- Check if the form was submitted via POST method ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // --- Include the consistent database connection from config.php ---
    require_once 'config.php';

    // --- Get the user's email input ---
    $email = $_POST["email"];

    // --- Generate a cryptographically secure random token ---
    $token = bin2hex(random_bytes(16));

    // --- Create a hash of the token to store in the database for security ---
    $token_hash = hash("sha256", $token);

    // --- Set an expiration date for the token (e.g., 30 minutes from now) ---
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    // --- Prepare SQL statement to update the user's record using PDO ---
    $sql = "UPDATE users
            SET reset_token_hash = ?,
                reset_token_expires_at = ?
            WHERE email = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$token_hash, $expiry, $email]);

    // --- Check if a database row was actually updated ---
    if ($stmt->rowCount()) {

        // --- Create a new PHPMailer instance ---
        $mail = new PHPMailer(true);

        try {
            // --- SMTP Server settings - REPLACE WITH YOUR CREDENTIALS ---
            $mail->isSMTP();
            $mail->Host       = 'smtp.example.com'; // Your SMTP server (e.g., mail.yourdomain.com)
            $mail->SMTPAuth   = true;
            $mail->Username   = 'your_email@example.com'; // Your SMTP username (e.g., no-reply@yourdomain.com)
            $mail->Password   = 'your_email_password';    // Your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use ENCRYPTION_SMTPS for SSL
            $mail->Port       = 587; // 587 for TLS, 465 for SSL

            // --- Email Recipients ---
            $mail->setFrom('no-reply@yourdomain.com', 'RAIS Create'); // The "from" address and name
            $mail->addAddress($email); // Add a recipient

            // --- Email Content ---
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $reset_link = BASE_URL . "/reset-password.php?token=$token";
            $mail->Body    = "Click <a href='{$reset_link}'>here</a> to reset your password.";
            $mail->AltBody = "Copy and paste this link into your browser to reset your password: {$reset_link}";

            $mail->send();
            $message = 'Message sent, please check your inbox.';
            $message_type = 'success';

        } catch (Exception $e) {
            // If the email fails to send, provide an error message
            $message = "Message could not be sent. Please contact support.";
            error_log("Mailer Error: {$mail->ErrorInfo}"); // Log the detailed error for you to see
            $message_type = 'danger';
        }
    } else {
        // IMPORTANT: For security, show a generic success message even if the email
        // is not in the database. This prevents attackers from guessing registered emails.
        $message = 'If an account with that email exists, a reset link has been sent.';
        $message_type = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="img/logoulit.png" />
    <style>
        /* --- General & Background Styles --- */
        body { font-family: 'Poppins', sans-serif; }
        .video-bg { position: fixed; top: 0; left: 0; min-width: 100%; min-height: 100%; object-fit: cover; z-index: -2; filter: blur(2px) brightness(0.8); }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: -1; }
        .form-container { background: rgba(0, 4, 4, 0.25); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.18); border-radius: 20px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); max-width: 900px; width: 100%; }
        .branding-section { background-color: #0C470C; border-top-left-radius: 20px; border-bottom-left-radius: 20px; }
        .form-section { padding: 3rem; }
        .form-control { border: none; border-radius: 10px; background-color: rgba(255, 255, 255, 0.2); color: white; }
        .form-floating > label { color: #ddd; }
        .form-control::placeholder { color: #ddd; }
        .form-control:focus { background-color: rgba(255, 255, 255, 0.3); box-shadow: 0 0 0 0.25rem rgba(12, 71, 12, 0.5); border-color: #106210; color: white; }
        .form-floating > .form-control:focus ~ label { color: #a5d6a7; }
        .btn-custom { background-color: #0C470C; border-radius: 25px; padding: 10px 25px; border: none; }
        .btn-custom:hover { background-color: #106210; transform: translateY(-3px); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); }
        .back-link:hover { color: #a5d6a7 !important; }
        @media (max-width: 991.98px) { .branding-section { border-radius: 20px 20px 0 0; } .form-container { max-width: 500px; } }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center vh-100 p-3">

    <video autoplay muted loop class="video-bg">
        <source src="vids/canadaaa.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="overlay"></div>

    <main class="form-container">
        <div class="row g-0">
            <div class="col-lg-5 d-none d-lg-flex flex-column justify-content-center align-items-center text-white p-5 branding-section">
                <img src="img/logowhite.png" alt="Company Logo" style="width: 120px; height: auto; margin-bottom: 1rem;">
                <h2 class="fw-bold mb-3">RAIS Create</h2>
                <p class="text-center small">Your trusted partner in Canadian immigration. Let's get you back on track.</p>
            </div>
            <div class="col-lg-7 text-white form-section text-center">
                <h2 class="mb-3 fs-2 fw-bold">Forgot Password?</h2>
                <p class="mb-4">No problem. Enter your email below and we'll send you a link to reset it.</p>
                
                <!-- Display success or error messages here -->
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $message_type; ?>" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="Enter your email" required>
                        <label for="floatingEmail">Enter your email</label>
                    </div>
                    <button type="submit" class="btn btn-custom text-white mt-3 fw-bold">Send Reset Link</button>
                </form>
                <a href="login.php" class="d-block mt-4 text-white text-decoration-none back-link">Back to Login</a>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
