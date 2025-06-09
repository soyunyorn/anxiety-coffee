<?php
session_start();
require "../config/config.php"; // $conn (your PDO)
require "../vendor/autoload.php"; // QR code library

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\Output\QRGdImagePNG;

// If already logged in, redirect
if (isset($_SESSION['username'])) {
  header("Location: /sreyneang/anxiety-coffee/");
  exit;
}

// Handle QR token verification (GET)
if (isset($_GET['token'])) {
  $token = $_GET['token'];

  $stmt = $conn->prepare("SELECT user_id FROM qr_sessions WHERE token = ? AND expires_at > NOW()");
  $stmt->execute([$token]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row && isset($row['user_id'])) {
    $user_id = $row['user_id'];

    // Fetch full user info
    $stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set session
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];

    // Clean up token
    $conn->prepare("DELETE FROM qr_sessions WHERE token = ?")->execute([$token]);

    // Redirect to homepage
    header("Location: /sreyneang/anxiety-coffee/");
    exit;
  } else {
    echo "❌ Invalid or expired token.";
    exit;
  }
}

// Handle form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $pass  = $_POST['password'] ?? '';

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($pass, $user['password'])) {
    if ($user['is_verified'] == 0) {
      echo "<script>alert('Please verify your email before logging in.');</script>";
    } else {
      $token = bin2hex(random_bytes(16));
      $expiresAt = date('Y-m-d H:i:s', time() + 300); // 5 min

      $conn->prepare("INSERT INTO qr_sessions (user_id, token, expires_at) VALUES (?, ?, ?)")
           ->execute([$user['id'], $token, $expiresAt]);

      // Generate QR URL
      $url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://')
           . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']
           . "?token={$token}";

      $options = new QROptions([
        'outputType' => QROutputInterface::GDIMAGE_PNG,
        'outputBase64' => false,
      ]);

      header('Content-Type: image/png');
      echo (new QRCode($options))->render($url);
      exit;
    }
  } else {
    echo "<script>alert('Email or password is wrong');</script>";
  }
}
?>

<!-- HTML form shown if no token -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>QR Login</title>
  <link rel="stylesheet" href="/sreyneang/anxiety-coffee/assets/css/style.css"> <!-- Optional -->
</head>
<body>
  <div class="container">
    <h2>Login with QR Code</h2>
    <form method="POST">
      <input name="email" type="email" placeholder="Email" required><br>
      <input name="password" type="password" placeholder="Password" required><br>
      <button type="submit">Generate QR Code</button>
    </form>
    <br>
    <a href="login.php">← Back to normal login</a>
  </div>
</body>
</html>
