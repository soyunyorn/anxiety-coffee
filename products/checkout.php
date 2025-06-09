<?php
ob_start(); // Fixes header redirect issue

require "../includes/header.php";
require "../config/config.php";

// Protect access
if (!isset($_SERVER['HTTP_REFERER'])) {
    header('location: http://localhost/anxiety-coffee');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header("location: " . APPURL . "");
    exit;
}

require "send_mail.php";

if (isset($_POST['submit'])) {

    // Validate required fields
    if (
        empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['state']) ||
        empty($_POST['street_address']) || empty($_POST['town']) || empty($_POST['zip_code']) ||
        empty($_POST['phone']) || empty($_POST['email'])
    ) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $state = trim($_POST['state']);
        $street_address = trim($_POST['street_address']);
        $town = trim($_POST['town']);
        $zip_code = trim($_POST['zip_code']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $user_id = $_SESSION['user_id'];
        $status = "Pending";
        $total_price = $_SESSION['total_price'] ?? 0;

        $place_orders = $conn->prepare("INSERT INTO orders (first_name, last_name, state, street_address, town, zip_code, phone, user_id, status, total_price)
            VALUES (:first_name, :last_name, :state, :street_address, :town, :zip_code, :phone, :user_id, :status, :total_price)");

        $place_orders->execute([
            ":first_name" => $first_name,
            ":last_name" => $last_name,
            ":state" => $state,
            ":street_address" => $street_address,
            ":town" => $town,
            ":zip_code" => $zip_code,
            ":phone" => $phone,
            ":user_id" => $user_id,
            ":status" => $status,
            ":total_price" => $total_price,
        ]);

        $order_id = $conn->lastInsertId();

        // Prepare email
        $subject = "Your Invoice for Order #$order_id";
        $body = "
            <h1>Thank you for your order!</h1>
            <p><strong>Order ID:</strong> $order_id</p>
            <p><strong>Name:</strong> $first_name $last_name</p>
            <p><strong>Shipping Address:</strong> $street_address, $town, $state, $zip_code</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Total Price:</strong> $" . number_format($total_price, 2) . "</p>
            <br>
            <p>We will process your order shortly.</p>
        ";

        $mailSent = sendEmail($email, "$first_name $last_name", $subject, $body);

        if (!$mailSent) {
            error_log("Invoice email failed for order $order_id");
        }

        header("location: pay.php");
        exit;
    }
}
?>

<!-- HTML Form -->
<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ftco-animate">
        <form action="checkout.php" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
          <h3 class="mb-4 billing-heading">Billing Details</h3>
          <div class="row align-items-end">
            <div class="col-md-6">
              <div class="form-group">
                <label>First Name</label>
                <input name="first_name" type="text" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Last Name</label>
                <input name="last_name" type="text" class="form-control" required>
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-12">
              <div class="form-group">
                <label>State / Country</label>
                <div class="select-wrap">
                  <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                  <select name="state" class="form-control" style="color: black;" required>
                    <option value="">-- Select Country --</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="France">France</option>
                    <option value="Italy">Italy</option>
                    <option value="Philippines">Philippines</option>
                    <option value="South Korea">South Korea</option>
                    <option value="Hongkong">Hongkong</option>
                    <option value="Japan">Japan</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Street Address</label>
                <input name="street_address" type="text" class="form-control" placeholder="House number and street name" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Town / City</label>
                <input name="town" type="text" class="form-control" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Postcode / ZIP *</label>
                <input name="zip_code" type="text" class="form-control" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Phone</label>
                <input name="phone" type="text" class="form-control" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Email Address</label>
                <input name="email" type="email" class="form-control" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mt-4">
                <button type="submit" name="submit" class="btn btn-primary py-3 px-4">Place an order and pay</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?php require "../includes/footer.php"; ?>
<?php ob_end_flush(); ?>
