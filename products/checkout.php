<?php 
require "../includes/header.php"; 
require "../config/config.php"; 
//session_start();

if(!isset($_SERVER['HTTP_REFERER'])){
    // Redirect if no referer
    header('location: http://localhost/anxiety-coffee');
    exit;
}

if(!isset($_SESSION['user_id'])) {
    header("location: ".APPURL."");
    exit;
}

// Include your PHPMailer send function file (adjust path if needed)
require "send_mail.php";

if(isset($_POST['submit'])) {

    // Check required fields
    if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['state']) || 
       empty($_POST['street_address']) || empty($_POST['town']) || empty($_POST['zip_code']) ||
       empty($_POST['phone']) || empty($_POST['email'])) {

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

        // Insert order into DB (make sure your orders table has 'email' column)
        $place_orders = $conn->prepare("INSERT INTO orders (first_name, last_name, state, street_address,
    town, zip_code, phone, user_id, status, total_price)
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


        // Get last inserted order ID
        $order_id = $conn->lastInsertId();

        // Prepare invoice email content (HTML)
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

        // Send invoice email to user - using your PHPMailer function
        $mailSent = sendEmail($email, "$first_name $last_name", $subject, $body);

        if(!$mailSent) {
            error_log("Invoice email sending failed for order $order_id");
        }

        // Redirect to payment page
        header("location: pay.php");
        exit;
    }
}
?>

<!-- Your existing HTML form below -->

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ftco-animate">
        <form action="checkout.php" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
          <h3 class="mb-4 billing-heading">Billing Details</h3>
          <div class="row align-items-end">
            <div class="col-md-6">
              <div class="form-group">
                <label for="firstname">First Name</label>
                <input name="first_name" type="text" class="form-control" placeholder="" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="lastname">Last Name</label>
                <input name="last_name" type="text" class="form-control" placeholder="" required>
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="country">State / Country</label>
                <div class="select-wrap">
                  <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                  <select name="state" class="form-control" required>
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
                <label for="streetaddress">Street Address</label>
                <input name="street_address" type="text" class="form-control" placeholder="House number and street name" required>
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="towncity">Town / City</label>
                <input name="town" type="text" class="form-control" placeholder="" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="postcodezip">Postcode / ZIP *</label>
                <input name="zip_code" type="text" class="form-control" placeholder="" required>
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="phone">Phone</label>
                <input name="phone" type="text" class="form-control" placeholder="" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="emailaddress">Email Address</label>
                <input name="email" type="email" class="form-control" placeholder="" required>
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-12">
              <div class="form-group mt-4">
                <button type="submit" name="submit" class="btn btn-primary py-3 px-4">Place an order and pay</button>
              </div>
            </div>
          </div>
        </form>
      </div> <!-- .col-md-12 -->
    </div> <!-- .row -->
  </div> <!-- .container -->
</section>

<?php require "../includes/footer.php"; ?>
