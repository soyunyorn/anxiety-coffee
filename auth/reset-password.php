<?php
ob_start(); // Start output buffering
require "../includes/header.php";
require "../config/config.php";

if (!isset($_GET['email'])) {
    header("Location: forgot-password.php");
    exit;
}

$email = $_GET['email'];
$error = "";

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($password) || empty($confirm_password)) {
        $error = "Please fill all password fields";
    } else if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = :password, verification_code = NULL WHERE email = :email");
        $update->execute([':password' => $hashed, ':email' => $email]);

        // Auto login user after reset password
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header("Location: ../index.php"); // Redirect to home page
            exit;
        } else {
            $error = "Something went wrong. Please try logging in.";
        }
    }
}

ob_end_flush(); // Flush output buffer
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
                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" style="cursor:pointer; position:absolute; right:10px; top:35px;"></span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
                <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password" style="cursor:pointer; position:absolute; right:10px; top:35px;"></span>
              </div>
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
  // Toggle password visibility
  document.querySelectorAll('.toggle-password').forEach(function(toggleIcon) {
    toggleIcon.addEventListener('click', function () {
      const input = document.querySelector(this.getAttribute('toggle'));
      if (input.type === 'password') {
        input.type = 'text';
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        this.classList.remove('fa-eye-slash');
        this.classList.add('fa-eye');
      }
    });
  });
</script>

<?php require "../includes/footer.php"; ?>
