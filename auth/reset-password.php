<?php
require "../includes/header.php";  // assumes ob_start() and session_start() inside
require "../config/config.php";

if (!isset($_GET['email'])) {
    header("Location: forgot-password.php");
    exit;
}

$email = $_GET['email'];
$error = "";

$password = "";
$confirm_password = "";

if (isset($_POST['submit'])) {
    $password = $_POST['password'] ?? "";
    $confirm_password = $_POST['confirm_password'] ?? "";

    if (empty($password) || empty($confirm_password)) {
        $error = "Please fill all password fields";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = :password, verification_code = NULL, is_verified = 1 WHERE email = :email");
        $update->execute([':password' => $hashed, ':email' => $email]);

        $user_check = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $user_check->execute([':email' => $email]);
        $user = $user_check->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header("Location: ../index.php");
            exit;
        } else {
            $error = "An unexpected error occurred. Please try logging in.";
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
        <form method="POST" action="reset-password.php?email=<?= htmlspecialchars(urlencode($email)) ?>" class="billing-form ftco-bg-dark p-3 p-md-5">
          <h3 class="mb-4 billing-heading">Reset Password</h3>
          <div class="row align-items-end">
            <div class="col-md-12">
              <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="New password" required>
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <input type="checkbox" onclick="togglePassword('password')"> Show Password
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <input type="checkbox" onclick="togglePassword('confirm_password')"> Show Confirm Password
            </div>

            <div class="col-md-12">
              <div class="form-group mt-4">
                <button type="submit" name="submit" class="btn btn-primary py-3 px-4">Reset Password</button>
              </div>
            </div>
          </div>
        </form><!-- END -->
      </div>
    </div>
  </div>
</section>

<script>
function togglePassword(fieldId) {
  const pwField = document.getElementById(fieldId);
  if (pwField.type === "password") {
    pwField.type = "text";
  } else {
    pwField.type = "password";
  }
}
</script>

<?php require "../includes/footer.php"; ?>
