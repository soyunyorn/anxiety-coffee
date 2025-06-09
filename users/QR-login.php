<?php
session_start();
require "../config/config.php"; // DB connection
require "../vendor/autoload.php"; // QR Code

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\Output\QRGdImagePNG;

// ✅ If user scans QR with token
if (isset($_GET['token'])) {
  $token = $_GET['token'];

  $stmt = $conn->prepare("SELECT user_id FROM qr_sessions WHERE token = ? AND expires_at > NOW()");
  $stmt->execute([$token]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row) {
    $user_id = $row['user_id'];

    $stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];

    $conn->prepare("DELETE FROM qr_sessions WHERE token = ?")->execute([$token]);

    header("Location: /sreyneang/anxiety-coffee/");
    exit;
  } else {
    echo "❌ Invalid or expired token.";
    exit;
  }
}

// ✅ If logged-in user opens this page, generate QR for another device
if (!isset($_SESSION['user_id'])) {
  echo "❌ You must be logged in to generate a QR code.";
  exit;
}

// Generate login token for QR
$user_id = $_SESSION['user_id'];
$token = bin2hex(random_bytes(16));
$expiresAt = date('Y-m-d H:i:s', time() + 300); // 5 minutes

$conn->prepare("INSERT INTO qr_sessions (user_id, token, expires_at) VALUES (?, ?, ?)")
     ->execute([$user_id, $token, $expiresAt]);

$url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://')
     . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']
     . "?token={$token}";

$options = new QROptions([
  'outputType' => QROutputInterface::GDIMAGE_PNG,
  'outputBase64' => true,
]);

$qr = (new QRCode($options))->render($url);
?>

<!-- ✅ Show QR code image -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Scan QR to Log In</title>
</head>
<body>
  <h2>📱 Scan this QR code on another device to log in</h2>
  <img src="<?= $qr ?>" alt="Login QR Code" />
  <p>This QR code is valid for 5 minutes.</p>
</body>
</html>
