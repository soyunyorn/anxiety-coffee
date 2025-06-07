<?php
require "../includes/header.php";
require "../config/config.php";
require "../vendor/autoload.php"; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['username'])) {
    header("location: " . APPURL . "");
    exit;
}

if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $verification_code = rand(100000, 999999); // 6-digit code
        $is_verified = 0;

        // Insert user into the database
        $insert = $conn->prepare("INSERT INTO users (username, email, password, verification_code, is_verified)
                                  VALUES (:username, :email, :password, :verification_code, :is_verified)");

        $insert->execute([
            ":username" => $username,
            ":email" => $email,
            ":password" => $password,
            ":verification_code" => $verification_code,
            ":is_verified" => $is_verified
        ]);

        // Send email with PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';         // e.g., Gmail SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'yornsoyun@gmail.com';   // your Gmail
            $mail->Password = 'gpvkevhhqksamxni';      // App password, not your real Gmail password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('yornsoyun@gmail.com', 'Anxiety Coffee');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your Email Verification Code';
            $mail->Body    = "Hello $username,<br><br>Your verification code is: <b>$verification_code</b>";

            $mail->send();


            header("Location: verify.php?email=" . urlencode($email));
            exit;
        } catch (Exception $e) {
            echo "<script>alert('Email could not be sent. Error: {$mail->ErrorInfo}');</script>";
        }
    }
}
?>


<!-- Your existing HTML form below unchanged -->
<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ftco-animate">
        <form action="register.php" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
          <h3 class="mb-4 billing-heading">Register</h3>
          <div class="row align-items-end">
            <div class="col-md-12">
              <div class="form-group">
                <label for="Username">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="Email">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Email">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
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
<?php require "../includes/footer.php"; ?>
