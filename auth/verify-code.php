<?php
require "../config/config.php";

if (!isset($_GET['email'])) {
    header("Location: forgot-password.php");
    exit;
}

$email = $_GET['email'];

$error = "";

if (isset($_POST['submit'])) {
    $code = trim($_POST['code']);

    if (empty($code)) {
        $error = "Please enter the verification code.";
    } else {
        $check = $conn->prepare("SELECT * FROM users WHERE email = :email AND verification_code = :code");
        $check->execute([':email' => $email, ':code' => $code]);
        $user = $check->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            header("Location: reset-password.php?email=" . urlencode($email));
            exit;
        } else {
            $error = "Invalid verification code.";
        }
    }
}

require "../includes/header.php";
?>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ftco-animate">
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="verify-code.php?email=<?= htmlspecialchars(urlencode($email)) ?>" class="billing-form ftco-bg-dark p-3 p-md-5">
          <h3 class="mb-4 billing-heading">Verify Code</h3>
          <div class="row align-items-end">
            <div class="col-md-12">
              <div class="form-group">
                <label for="code">Verification Code</label>
                <input type="text" name="code" class="form-control" placeholder="Enter the code sent to your email" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mt-4">
                <button type="submit" name="submit" class="btn btn-primary py-3 px-4">Verify</button>
              </div>
            </div>
          </div>
        </form><!-- END -->
      </div>
    </div>
  </div>
</section>

<?php require "../includes/footer.php"; ?>
