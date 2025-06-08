<?php
ob_start();  // Start output buffering
require "../config/config.php";
require "../vendor/autoload.php"; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if (isset($_SESSION['username'])) {
    header("location: " . APPURL);
    exit();
}

if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        $error = "One or more inputs are empty";
    } else {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $verification_code = rand(100000, 999999);
        $is_verified = 0;

        // Insert user into DB
        $insert = $conn->prepare("INSERT INTO users (username, email, password, verification_code, is_verified)
                                  VALUES (:username, :email, :password, :verification_code, :is_verified)");

        $insert->execute([
            ":username" => $username,
            ":email" => $email,
            ":password" => $password,
            ":verification_code" => $verification_code,
            ":is_verified" => $is_verified
        ]);

        // Send verification email
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'yornsoyun@gmail.com';
            $mail->Password = 'gpvkevhhqksamxni'; // your app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('yornsoyun@gmail.com', 'Anxiety Coffee');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your Email Verification Code';
            $mail->Body    = "Hello $username,<br><br>Your verification code is: <b>$verification_code</b>";

            $mail->send();

            header("Location: verify.php?email=" . urlencode($email));
            exit();
        } catch (Exception $e) {
            $error = "Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    }
}

ob_end_flush(); // End output buffering
?>

<?php require "../includes/header.php"; ?>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ftco-animate">
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="register.php" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
          <h3 class="mb-4 billing-heading">Register</h3>
          <div class="row align-items-end">
            <div class="col-md-12">
              <div class="form-group">
                <label for="Username">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <div class="mt-2">
                  <input type="checkbox" id="showPassword"> <label for="showPassword">Show Password</label>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mt-4">
                <button type="submit" name="submit" class="btn btn-primary py-3 px-4">Register</button>
              </div>
            </div>
          </div>
        </form><!-- END -->
      </div>
    </div>
  </div>
</section>

<script>
  document.getElementById('showPassword').addEventListener('change', function() {
    const passwordInput = document.getElementById('password');
    passwordInput.type = this.checked ? 'text' : 'password';
  });
</script>

<?php require "../includes/footer.php"; ?>
