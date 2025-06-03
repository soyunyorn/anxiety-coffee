<?php
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
        echo "<script>alert('Please fill all password fields');</script>";
    } else if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = :password, verification_code = NULL WHERE email = :email");
        $update->execute([':password' => $hashed, ':email' => $email]);

        echo "<script>alert('Password reset successful. You can now login.'); window.location='login.php';</script>";
        exit;
    }
}
?>

<section class="ftco-section">
  <div class="container">
    <h3>Reset Password</h3>
    <form method="POST" action="reset-password.php?email=<?= htmlspecialchars(urlencode($email)) ?>">
      <div class="form-group">
        <label>New Password</label>
        <input type="password" name="password" class="form-control" placeholder="New password">
      </div>
      <div class="form-group">
        <label>Confirm New Password</label>
        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password">
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Reset Password</button>
    </form>
  </div>
</section>

<?php require "../includes/footer.php"; ?>
