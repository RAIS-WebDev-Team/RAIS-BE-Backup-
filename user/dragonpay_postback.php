<?php
// This is the server-to-server postback URL.
// Dragonpay sends a request here in the background to confirm the transaction status.
// THIS is where you should update your database.

require_once '../config.php';

// --- IMPORTANT: REPLACE WITH YOUR ACTUAL DRAGONPAY SECRET KEY ---
$secretKey = 'YOUR_SECRET_KEY';   // Replace with your Dragonpay Secret Key
// --------------------------------------------------------------------

// Read the parameters from the POST request from Dragonpay's server
$txnid = $_POST['txnid'] ?? '';
$refno = $_POST['refno'] ?? '';
$status = $_POST['status'] ?? '';
$message = $_POST['message'] ?? '';
$digest = $_POST['digest'] ?? '';
$amount = $_POST['amount'] ?? ''; // It's good practice to get amount if sent

// --- VERIFY THE DIGEST ---
// This is a security measure to ensure the request is from Dragonpay.
$localDigestStr = "$txnid:$refno:$status:$message:$secretKey";
$localDigest = sha1($localDigestStr);

if ($digest !== $localDigest) {
    // If digests don't match, log the error and exit.
    // This could be a fraudulent request.
    error_log("Dragonpay Postback: Digest mismatch for transaction ID $txnid");
    header("HTTP/1.1 400 Bad Request");
    echo "RESULT=FAIL";
    exit;
}

// --- PROCESS THE TRANSACTION ---

// Extract the user ID from the transaction ID (based on the format 'RAIS-USERID-TIMESTAMP')
$txnid_parts = explode('-', $txnid);
if (count($txnid_parts) < 2 || !is_numeric($txnid_parts[1])) {
    error_log("Dragonpay Postback: Could not parse user ID from txnid: $txnid");
    echo "RESULT=FAIL";
    exit;
}
$userId = (int)$txnid_parts[1];

if ($status === 'S') { // 'S' means the payment was successful
    try {
        $conn->begin_transaction();
        
        // 1. Check if this transaction has already been processed to prevent duplicates
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM statement_of_account WHERE description = ?");
        $description = "Dragonpay Payment Ref: $refno";
        $checkStmt->bind_param("s", $description);
        $checkStmt->execute();
        $count = $checkStmt->get_result()->fetch_row()[0];
        $checkStmt->close();

        if ($count == 0) {
            // 2. Insert the payment record into the statement of account
            $insertStmt = $conn->prepare(
                "INSERT INTO statement_of_account (user_id, transaction_date, description, payments) VALUES (?, CURDATE(), ?, ?)"
            );
            $insertStmt->bind_param("isd", $userId, $description, $amount);
            $insertStmt->execute();
            $insertStmt->close();
        }

        $conn->commit();
        echo "RESULT=OK"; // Acknowledge to Dragonpay that we've processed it.

    } catch (Exception $e) {
        $conn->rollback();
        error_log("Dragonpay Postback DB Error for txnid $txnid: " . $e->getMessage());
        echo "RESULT=FAIL"; // Tell Dragonpay there was an error
    }

} else {
    // If status is not 'S' (e.g., 'F' for failed), you might want to log it
    // but you don't need to update the statement of account.
    error_log("Dragonpay Postback: Received non-successful status '$status' for txnid $txnid. Message: $message");
    echo "RESULT=OK"; // Still acknowledge it to stop Dragonpay from retrying.
}

$conn->close();

?>
