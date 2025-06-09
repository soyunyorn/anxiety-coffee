<?php
session_start();
require "../config/config.php"; // DB connection ($conn)
require "../vendor/autoload.php"; // QR code lib

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QROutputInterface;

function debugLog($msg) {
    error_log("[QR-login DEBUG] " . $msg);
}

// === Handle token login (scanning QR) ===
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    debugLog("Received token: $token");

    $stmt = $conn->prepare("SELECT user_id FROM qr_sessions WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $user_id = $row['user_id'];
        debugLog("Token valid for user_id: $user_id");

        // Fetch user info
        $stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            debugLog("User not found in DB for user_id: $user_id");
            echo "❌ User not found.";
            exit;
        }

        // Set session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        // Delete used token
        $conn->prepare("DELETE FROM qr_sessions WHERE token = ?")->execute([$token]);
        debugLog("Token deleted from DB");

        // Redirect after login
        header("Location: /sreyneang/anxiety-coffee/");
        exit;
    } else {
        debugLog("Invalid or expired token: $token");
        echo "❌ Invalid or expired token.";
        exit;
    }
}

// === Generate QR for logged-in user ===
if (!isset($_SESSION['user_id'])) {
    echo "❌ You must be logged in to generate a QR code.";
    exit;
}

$user_id = $_SESSION['user_id'];
$token = bin2hex(random_bytes(16));
$expiresAt = date('Y-m-d H:i:s', time() + 300);

$insert = $conn->prepare("INSERT INTO qr_sessions (user_id, token, expires_at) VALUES (?, ?, ?)");
$success = $insert->execute([$user_id, $token, $expiresAt]);

if (!$success) {
    debugLog("Failed to insert token into DB");
    echo "❌ Failed to generate QR code token.";
    exit;
}

debugLog("Generated token: $token for user_id: $user_id");

$url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://')
     . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']
     . "?token={$token}";

$options = new QROptions([
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'outputBase64' => true,
]);

$qr = (new QRCode($options))->render($url);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Scan QR to Log In</title>
</head>
<body>
  <h2>📱 Scan this QR code on another device to log in</h2>
  <img src="<?= $qr ?>" alt="Login QR Code" />
  <p>This QR code is valid for 5 minutes.</p>
  <hr>
  <h3>Debug Info</h3>
  <p><strong>QR login URL:</strong> <a href="<?= htmlspecialchars($url) ?>" target="_blank"><?= htmlspecialchars($url) ?></a></p>
</body>
</html>
