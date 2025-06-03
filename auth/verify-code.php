<?php
require "../includes/header.php";
require "../config/config.php";

if (!isset($_GET['email'])) {
    header("Location: forgot-password.php");
    exit;
}

$email = $_GET['email'];

if (isset($_POST['submit'])) {
    $code = trim($_POST['code']);

    if (empty($code)) {
        echo "<script>alert('Please enter the verification code');</script>";
    } else {
        $check = $conn->prepare("SELECT * FROM users WHERE email = :email AND verification_code = :code");
        $check->execute([':email' => $email, ':code' => $code]);
        $user = $check->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Code matches, redirect to reset password page
            header("Location: reset-password.php?email=" . urlencode($email));
            exit;
        } else {
            echo "<script>alert('Invalid verification code');</script>";
        }
    }
}
?>

<section class="ftco-section">
  <div class="container">
    <h3>Verify Your Code</h3>
    <form method="POST" action="verify-code.php?email=<?= htmlspecialchars(urlencode($email)) ?>">
      <div class="form-group">
        <label>Enter the code you received</label>
        <input type="text" name="code" class="form-control" placeholder="Verification code">
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Verify Code</button>
    </form>
  </div>
</section>

<?php require "../includes/footer.php"; ?>
