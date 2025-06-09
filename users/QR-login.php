<?php
session_start();
require __DIR__ . '/../../vendor/autoload.php'; // Adjust path to autoload if needed

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\Output\QRGdImagePNG;

// ----------------------
// Database connection
// ----------------------
function getPdo() {
    $host = 'localhost';
    $db   = 'your_database';
    $user = 'your_username';
    $pass = 'your_password';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    return new PDO($dsn, $user, $pass, $options);
}

$pdo = getPdo();

// ----------------------
// Serve QR image
// ----------------------
if (isset($_GET['action']) && $_GET['action'] === 'qr' && isset($_SESSION['qr_token'])) {
    $token = $_SESSION['qr_token'];

    $options = new QROptions([
        'outputType' => QROutputInterface::GDIMAGE_PNG,
        'outputInterface' => QRGdImagePNG::class,
        'outputBase64' => false,
    ]);

    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']
         . '?token=' . urlencode($token);

    header('Content-Type: image/png');
    echo (new QRCode($options))->render($url);
    exit;
}

// ----------------------
// Poll for login status
// ----------------------
if (isset($_GET['action']) && $_GET['action'] === 'check') {
    header('Content-Type: application/json');

    if (!isset($_SESSION['qr_token'])) {
        echo json_encode(['logged_in' => false]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT user_id FROM qr_sessions WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$_SESSION['qr_token']]);
    $row = $stmt->fetch();

    if ($row) {
        $_SESSION['user_id'] = $row['user_id'];
        $pdo->prepare("DELETE FROM qr_sessions WHERE token = ?")->execute([$_SESSION['qr_token']]);
        unset($_SESSION['qr_token']);
        echo json_encode(['logged_in' => true]);
    } else {
        echo json_encode(['logged_in' => false]);
    }
    exit;
}

// ----------------------
// Token validation (QR scan callback)
// ----------------------
if (isset($_GET['token'])) {
    $stmt = $pdo->prepare("SELECT user_id FROM qr_sessions WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$_GET['token']]);
    $row = $stmt->fetch();

    if ($row) {
        $_SESSION['user_id'] = $row['user_id'];
        $pdo->prepare("DELETE FROM qr_sessions WHERE token = ?")->execute([$_GET['token']]);
        echo "✅ Login successful via QR! You can now go back to the original browser.";
    } else {
        echo "❌ Invalid or expired token.";
    }
    exit;
}

// ----------------------
// Login form submit -> generate QR
// ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $pass  = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        $token = bin2hex(random_bytes(16));
        $expiresAt = date('Y-m-d H:i:s', time() + 300); // 5 minutes

        $pdo->prepare("INSERT INTO qr_sessions (user_id, token, expires_at) VALUES (?, ?, ?)")
            ->execute([$user['id'], $token, $expiresAt]);

        $_SESSION['qr_token'] = $token;

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Scan QR Code to Login</title>
            <style>
                body { font-family: sans-serif; text-align: center; margin-top: 50px; }
                img { margin: 20px auto; }
            </style>
        </head>
        <body>
            <h2>Scan this QR code with your device</h2>
            <p>It will expire in 5 minutes</p>
            <img src="?action=qr" alt="QR Code">

            <script>
                setInterval(() => {
                    fetch('?action=check')
                        .then(res => res.json())
                        .then(data => {
                            if(data.logged_in){
                                window.location.href = '?success=1';
                            }
                        });
                }, 3000);
            </script>
        </body>
        </html>
        <?php
        exit;
    } else {
        echo "<p style='color:red;'>❌ Invalid email or password.</p>";
    }
}

// ----------------------
// Final screen after login
// ----------------------
if (isset($_GET['success']) && isset($_SESSION['user_id'])) {
    echo "<h2>🎉 Login successful! Welcome to your dashboard.</h2>";
    exit;
}

// ----------------------
// Login Form (default view)
// ----------------------
?>
<!DOCTYPE html>
<html>
<head>
    <title>QR Code Login</title>
</head>
<body>
    <h2>Login to Generate QR Code</h2>
    <form method="POST">
        <input name="email" type="email" placeholder="Email" required><br>
        <input name="password" type="password" placeholder="Password" required><br>
        <button type="submit">Login & Generate QR</button>
    </form>
</body>
</html>
