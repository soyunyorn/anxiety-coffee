<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php 
if (isset($_SESSION['username'])) {
  header("location: " . APPURL);
  exit;
}

if (isset($_POST['submit'])) {
  if (empty($_POST['email']) || empty($_POST['password'])) {
    echo "<script>alert('One or more inputs are empty');</script>";
  } else {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $login->execute([':email' => $email]);
    $fetch = $login->fetch(PDO::FETCH_ASSOC);

    if ($login->rowCount() > 0) {
      if ($fetch['is_verified'] == 0) {
        echo "<script>alert('Please verify your email first before logging in.');</script>";
      } else if (password_verify($password, $fetch['password'])) {
        $_SESSION['username'] = $fetch['username'];
        $_SESSION['email'] = $fetch['email'];
        $_SESSION['user_id'] = $fetch['id'];

        // ✅ Redirect to home page
        header("Location: " . APPURL);
        exit;
      } else {
        echo "<script>alert('Email or password is wrong');</script>";
      }
    } else {
      echo "<script>alert('Email or password is wrong');</script>";
    }
  }
}
?>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ftco-animate">
        <form action="login.php" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
          <h3 class="mb-4 billing-heading">Login</h3>
          <div class="row align-items-end">
            <div class="col-md-12">
              <div class="form-group">
                <label for="Email">Email</label>
                <input name="email" type="text" class="form-control" placeholder="Email" required>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label for="Password">Password</label>
                <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                <div class="mt-2">
                  <input type="checkbox" id="showPassword">
                  <label for="showPassword" style="color: #fff;">Show Password</label>
                </div>
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
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Show/hide password script -->
<script>
  document.getElementById('showPassword').addEventListener('change', function () {
    const pw = document.getElementById('password');
    pw.type = this.checked ? 'text' : 'password';
  });
</script>

<?php require "../includes/footer.php"; ?>
