<?php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

// --- PHPMailer Integration ---
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


$action = $_REQUEST['action'] ?? null;
$response = ['success' => false, 'message' => 'Invalid action.'];

switch ($action) {
    case 'subscribe':
        if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['email'];
            try {
                // Check if email already exists
                $stmt = $pdo->prepare("SELECT id FROM newsletter_subscriptions WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $response['message'] = 'This email is already subscribed!';
                } else {
                    // Insert new email
                    $stmt = $pdo->prepare("INSERT INTO newsletter_subscriptions (email) VALUES (?)");
                    if ($stmt->execute([$email])) {
                        
                        // --- SEND CONFIRMATION EMAIL ---
                        $mail = new PHPMailer(true);
                        try {
                            //Server settings - REPLACE WITH YOUR CREDENTIALS
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.example.com'; // Your SMTP server (e.g., smtp.gmail.com or your host's SMTP server)
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'your_email@example.com'; // Your SMTP username
                            $mail->Password   = 'your_email_password';    // Your SMTP password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Or PHPMailer::ENCRYPTION_SMTPS for SSL
                            $mail->Port       = 587; // 587 for TLS, 465 for SSL

                            //Recipients
                            $mail->setFrom('no-reply@yourdomain.com', 'Roman & Associates'); // The "from" address
                            $mail->addAddress($email); // Add a recipient (the new subscriber)

                            //Content
                            $mail->isHTML(true);
                            $mail->Subject = 'Subscription Confirmed!';
                            $mail->Body    = '<h1>Thank you for subscribing!</h1><p>You have been successfully added to our newsletter. You will now receive the latest updates and tips from Roman & Associates.</p>';
                            $mail->AltBody = 'Thank you for subscribing! You have been successfully added to our newsletter.';

                            $mail->send();
                            $response = ['success' => true, 'message' => 'Thank you for subscribing! A confirmation has been sent to your email.'];

                        } catch (Exception $e) {
                            // Email failed to send, but subscription was saved.
                            error_log("Mailer Error: {$mail->ErrorInfo}"); // Log the error for debugging
                            $response = ['success' => true, 'message' => 'Thank you for subscribing! (Could not send confirmation email).'];
                        }
                        
                    } else {
                        $response['message'] = 'Failed to subscribe. Please try again.';
                    }
                }
            } catch (PDOException $e) {
                $response['message'] = 'Database error: ' . $e->getMessage();
            }
        } else {
            $response['message'] = 'Please provide a valid email address.';
        }
        break;

    case 'fetch':
        // Security Check: This part should only be accessible by admins
        if (!isset($_SESSION['loggedin']) || strpos($_SESSION['role'], 'Admin') === false) {
            $response = ['success' => false, 'message' => 'Unauthorized'];
            break;
        }

        try {
            $stmt = $pdo->query("SELECT id, email, subscription_date FROM newsletter_subscriptions ORDER BY subscription_date DESC");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response = ['success' => true, 'data' => $data];
        } catch (PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
        break;
}

echo json_encode($response);
?>
```

### Step 3: Configure Your SMTP Credentials

The final and most important step is to replace the placeholder values in the code with your actual email account details.

Find this section in the `api_newsletter.php` file you just updated:

```php
//Server settings - REPLACE WITH YOUR CREDENTIALS
$mail->isSMTP();
$mail->Host       = 'smtp.example.com'; // Your SMTP server
$mail->SMTPAuth   = true;
$mail->Username   = 'your_email@example.com'; // Your SMTP username
$mail->Password   = 'your_email_password';    // Your SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
$mail->Port       = 587; 

