<?php
session_start();
require_once '../config.php';

// --- IMPORTANT: REPLACE WITH YOUR ACTUAL DRAGONPAY CREDENTIALS ---
$merchantId = 'YOUR_MERCHANT_ID'; // Replace with your Dragonpay Merchant ID
$secretKey = 'YOUR_SECRET_KEY';   // Replace with your Dragonpay Secret Key
// --------------------------------------------------------------------

// Dragonpay Gateway URL
$dragonpayUrl = 'https://gw.dragonpay.ph/Pay.aspx'; // Use http://test.dragonpay.ph/Pay.aspx for testing

// Check if the form was submitted correctly
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['amount']) || !is_numeric($_POST['amount'])) {
    die('Invalid request.');
}

// --- GATHER PAYMENT DETAILS ---
$amount = number_format($_POST['amount'], 2, '.', ''); // Format to 2 decimal places
$currency = 'PHP';
$description = $_POST['description'] ?? 'Payment for services';
$email = $_POST['email'] ?? '';

// Generate a unique transaction ID. 
// It's good practice to prefix it with something unique to your site.
$transactionId = 'RAIS-' . $_SESSION['id'] . '-' . time();

// --- CREATE THE DIGEST FOR SECURITY ---
// The digest is a SHA1 hash of the parameters concatenated with your secret key.
// The order of fields is important.
$digestStr = "$merchantId:$transactionId:$amount:$currency:$description:$secretKey";
$digest = sha1($digestStr);

// --- PREPARE PARAMETERS FOR REDIRECT ---
$parameters = [
    'merchantid' => $merchantId,
    'txnid'      => $transactionId,
    'amount'     => $amount,
    'ccy'        => $currency,
    'description'=> $description,
    'email'      => $email,
    'digest'     => $digest,
];

// Optional parameters (you can add more as needed)
// 'param1' => 'your_custom_data1',
// 'param2' => 'your_custom_data2',

// Redirect the user to the Dragonpay payment gateway
$redirectUrl = $dragonpayUrl . '?' . http_build_query($parameters);
header("Location: " . $redirectUrl);
exit;

?>
