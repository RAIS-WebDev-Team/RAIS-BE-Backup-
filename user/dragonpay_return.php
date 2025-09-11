<?php
session_start();
// --- IMPORTANT: REPLACE WITH YOUR ACTUAL DRAGONPAY SECRET KEY ---
$secretKey = 'YOUR_SECRET_KEY'; // Replace with your Dragonpay Secret Key
// ---------------------------------------------------------------

// Get parameters from Dragonpay
$txnid = $_GET['txnid'] ?? '';
$refno = $_GET['refno'] ?? '';
$status = $_GET['status'] ?? '';
$message = $_GET['message'] ?? '';
$digest = $_GET['digest'] ?? '';

// Verify the digest to ensure the request is from Dragonpay and hasn't been tampered with
$localDigestStr = "$txnid:$refno:$status:$message:$secretKey";
$localDigest = sha1($localDigestStr);

$pageTitle = "Payment Status";
$alertClass = "alert-danger";
$alertMessage = "An error occurred. The payment response could not be verified. Please contact support.";

if ($digest === $localDigest) {
    // Digest is valid, show status to the user
    switch ($status) {
        case 'S':
            $pageTitle = "Payment Successful";
            $alertClass = "alert-success";
            $alertMessage = "Thank you! Your payment has been successfully processed. Your reference number is <strong>$refno</strong>.";
            break;
        case 'F':
            $pageTitle = "Payment Failed";
            $alertClass = "alert-danger";
            $alertMessage = "Your payment failed. Reason: " . htmlspecialchars($message) . ". Please try again or contact support.";
            break;
        case 'P':
            $pageTitle = "Payment Pending";
            $alertClass = "alert-warning";
            $alertMessage = "Your payment is currently pending. We will notify you once the status is updated.";
            break;
        default:
            $pageTitle = "Payment Error";
            $alertClass = "alert-danger";
            $alertMessage = "An unknown payment status was received. Please contact support and provide your transaction ID: <strong>$txnid</strong>.";
            break;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f7f7f7; }
        .status-container { max-width: 600px; margin-top: 50px; }
    </style>
</head>
<body>
    <div class="container status-container">
        <div class="card shadow-sm">
            <div class="card-body p-5 text-center">
                <h1 class="card-title"><?php echo $pageTitle; ?></h1>
                <div class="alert <?php echo $alertClass; ?> mt-4">
                    <?php echo $alertMessage; ?>
                </div>
                <a href="statement-of-account.php" class="btn btn-primary mt-4">Return to Statement of Account</a>
            </div>
        </div>
    </div>
</body>
</html>
