<?php
ob_start();
require "../includes/header.php";
require "../config/config.php";
require "../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);

    if (empty($email)) {
        echo "<script>alert('Please enter your email');</script>";
    } else {
        // Check if email exists
        $check = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $check->execute([':email' => $email]);
        $user = $check->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $verification_code = rand(100000, 999999);
            // Save verification code in DB
            $update = $conn->prepare("UPDATE users SET verification_code = :code WHERE email = :email");
            $update->execute([':code' => $verification_code, ':email' => $email]);

            // Send email with code
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'yornsoyun@gmail.com';    // Your Gmail
                $mail->Password = 'gpvkevhhqksamxni';       // App password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('yornsoyun@gmail.com', 'Anxiety Coffee');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Verification Code';
                $mail->Body = "Hello,<br><br>Your password reset code is: <b>$verification_code</b>";

                $mail->send();

                // Redirect to verify-code page with email parameter
                header("Location: verify-code.php?email=" . urlencode($email));
                exit;
            } catch (Exception $e) {
                echo "<script>alert('Could not send email. Mailer Error: {$mail->ErrorInfo}');</script>";
            }
        } else {
            echo "<script>alert('This email is not registered');</script>";
        }
    }
}
?>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ftco-animate">
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="forgot-password.php" class="billing-form ftco-bg-dark p-3 p-md-5">
          <h3 class="mb-4 billing-heading">Forgot Password</h3>
          <div class="row align-items-end">
            <div class="col-md-12">
              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your registered email" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mt-4">
                <button type="submit" name="submit" class="btn btn-primary py-3 px-4">Send Verification Code</button>
              </div>
            </div>
          </div>
        </form><!-- END -->
      </div>
    </div>
  </div>
</section>

<?php
require "../includes/footer.php";
ob_end_flush();
?>
