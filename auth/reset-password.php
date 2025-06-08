<?php
ob_start();
require "../includes/header.php";
require "../config/config.php";

if (!isset($_GET['email'])) {
    header("Location: forgot-password.php");
    exit;
}

$email = $_GET['email'];

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($password) || empty($confirm_password)) {
        $error = "Please fill in all password fields.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = :password, verification_code = NULL WHERE email = :email");
        $update->execute([':password' => $hashed, ':email' => $email]);

        // Auto-login user
        $getUser = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $getUser->execute([':email' => $email]);
        $user = $getUser->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
        }

        header("Location: " . APPURL);
        exit;
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
                <input type="password" name="password" id="password" class="form-control" placeholder="New password" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <input type="checkbox" id="togglePassword"> <label for="togglePassword">Show Password</label>
            </div>
            <div class="col-md-12">
              <div class="form-group mt-4">
                <button type="submit" name="submit" class="btn btn-primary py-3 px-4">Reset Password</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Password Toggle Script -->
<script>
  const toggle = document.getElementById("togglePassword");
  const pwd1 = document.getElementById("password");
  const pwd2 = document.getElementById("confirm_password");

  toggle.addEventListener("change", function () {
    const type = this.checked ? "text" : "password";
    pwd1.type = type;
    pwd2.type = type;
  });
</script>

<?php
require "../includes/footer.php";
ob_end_flush();
?>
