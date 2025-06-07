<?php
require "../includes/header.php";
require "../config/config.php";

if (isset($_SESSION['username'])) {
    header("Location: " . APPURL);
    exit;
}

if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    // Redirect back if no email
    header("Location: register.php");
    exit;
}

if (isset($_POST['submit'])) {
    $input_code = $_POST['verification_code'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['verification_code'] == $input_code) {
            // Update verification status
            $update = $conn->prepare("UPDATE users SET is_verified = 1 WHERE email = :email");
            $update->execute([':email' => $email]);

            // Log the user in automatically
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];

            header("Location: " . APPURL);
            exit;
        } else {
            echo "<script>alert('Verification code is incorrect. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('User not found.');</script>";
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
