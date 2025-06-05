<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require "../config/config.php";

if (!isset($_GET['email'])) {
    die('Email missing');
}

$email = $_GET['email'];

if (isset($_POST['submit'])) {
    $input_code = $_POST['verification_code'];
    $stmt = $conn->prepare("SELECT verification_code FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['verification_code'] == $input_code) {
        $update = $conn->prepare("UPDATE users SET is_verified = 1, verification_code = NULL WHERE email = :email");
        $update->execute([':email' => $email]);
        echo "Verification successful! You can now log in.";
        exit;
    } else {
        echo "Incorrect code or user not found.";
    }
}
?>




<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 ftco-animate">
        <form action="verify.php?email=<?php echo urlencode($email); ?>" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
          <h3 class="mb-4 billing-heading text-center">Verify Your Email</h3>
          <p class="text-center">Please enter the verification code sent to your email: <strong><?php echo htmlspecialchars($email); ?></strong></p>

          <div class="form-group">
            <label for="verification_code">Verification Code</label>
            <input type="text" name="verification_code" class="form-control" placeholder="Enter your code here" required>
          </div>

          <div class="form-group mt-4 text-center">
            <button type="submit" name="submit" class="btn btn-primary py-3 px-4">Verify</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?php require "../includes/footer.php"; ?>
