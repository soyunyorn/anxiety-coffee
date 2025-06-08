<?php
require "../config/config.php"; // Load config first
require "../includes/functions.php"; // If any

session_start(); // Remove this if already in header.php, or just ignore it here

// Handle login first before output starts
if (isset($_SESSION['username'])) {
    header("Location: " . APPURL . "/index.php");
    exit;
}

if (isset($_POST['submit'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "One or more inputs are empty";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            if ($user['is_verified'] == 0) {
                $error = "Please verify your email before logging in.";
            } elseif (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];

                header("Location: " . APPURL . "/index.php");
                exit;
            } else {
                $error = "Email or password is incorrect.";
            }
        } else {
            $error = "Email or password is incorrect.";
        }
    }
}
?>

<?php require "../includes/header.php"; ?>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ftco-animate">
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
          <h3 class="mb-4 billing-heading">Login</h3>
          <div class="row align-items-end">
            <div class="col-md-12">
              <div class="form-group">
                <label for="Email">Email</label>
                <input name="email" type="text" class="form-control" placeholder="Email">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="Password">Password</label>
                <input name="password" type="password" class="form-control" placeholder="Password">
              </div>
            </div>

            <div class="col-md-12">
              <a href="forgot-password.php" style="color: #fff; display: block; margin-bottom: 15px;">Forgot Password?</a>
            </div>

            <div class="col-md-12">
              <div class="form-group mt-4">
                <button type="submit" name="submit" class="btn btn-primary py-3 px-4">Login</button>
              </div>
            </div>
          </div>
        </form><!-- END -->
      </div>
    </div>
  </div>
</section>

<?php require "../includes/footer.php"; ?>
