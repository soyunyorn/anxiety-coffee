<?php
session_start();
require __DIR__ . '/../vendor/autoload.php'; // Composer autoload
require __DIR__ . '/db.php';                // Your PDO connection (getPdo())

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\Output\QRGdImagePNG;

$pdo = getPdo(); // Replace with your actual DB connection

// 1️⃣ POST: User login -> generate token + display QR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_GET['token'])) {
    $email = $_POST['email'] ?? '';
    $pass  = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        $token = bin2hex(random_bytes(16));
        $expiresAt = date('Y-m-d H:i:s', time() + 300);

        $pdo->prepare("INSERT INTO qr_sessions (user_id, token, expires_at) VALUES (?, ?, ?)")
            ->execute([$user['id'], $token, $expiresAt]);

        // Generate QR code pointing to this script
        $url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://')
             . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']
             . "?token={$token}";

        $options = new QROptions();
        $options->outputType = QROutputInterface::GDIMAGE_PNG;
        $options->outputInterface = QRGdImagePNG::class;
        $options->outputBase64 = false;

        header('Content-Type: image/png');
        echo (new QRCode($options))->render($url);
        exit;
    } else {
        echo "Invalid credentials.";
    }

// 2️⃣ GET: With token -> validate and complete login
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare("SELECT user_id FROM qr_sessions WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $row = $stmt->fetch();

    if ($row) {
        $_SESSION['user_id'] = $row['user_id'];
        echo "✅ Login successful!";

        $pdo->prepare("DELETE FROM qr_sessions WHERE token = ?")->execute([$token]);
    } else {
        echo "❌ Invalid or expired token.";
    }

// 3️⃣ No token or form submitted -> show login form
} else {
    echo '
    <h2>QR Login</h2>
    <form method="POST">
      <input name="email" type="email" placeholder="Email" required><br>
      <input name="password" type="password" placeholder="Password" required><br>
      <button type="submit">Login & Generate QR</button>
    </form>';
}
