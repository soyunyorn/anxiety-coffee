<?php 
require "includes/header.php"; 
require "config/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize form inputs
    $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $subject = filter_var($_POST['subject'] ?? '', FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_STRING);

    if ($name && $email && $subject && $message) {
        $to = "yornsoyun@gmail.com";
        $headers = "From: $email\r\nReply-To: $email\r\n";
        $fullMessage = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        if (mail($to, $subject, $fullMessage, $headers)) {
            echo "<div class='alert alert-success'>Thank you for contacting us. We'll get back to you shortly.</div>";
        } else {
            echo "<div class='alert alert-danger'>Oops! Something went wrong. Please try again later.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Please fill in all fields correctly.</div>";
    }
}
?>

<section class="ftco-section contact-section">
  <div class="container mt-5">
    <div class="row block-9">
      <div class="col-md-4 contact-info ftco-animate">
        <!-- Contact info unchanged -->
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-6 ftco-animate">
        <form action="" method="POST" class="contact-form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
          </div>
          <div class="form-group">
            <textarea name="message" cols="30" rows="7" class="form-control" placeholder="Message" required></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<div id="map"></div>

<?php require "includes/footer.php"; ?>
