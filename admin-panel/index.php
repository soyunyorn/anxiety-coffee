<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "layouts/header.php";    
require "../config/config.php";    

if(!isset($_SESSION['admin_name'])) {
    header("location: ".ADMINURL."/admins/login-admins.php");
    exit;
}

// Products
$products = $conn->query("SELECT COUNT(*) AS count_products FROM products");
$productsCount = $products->fetch(PDO::FETCH_OBJ);

// Orders
$orders = $conn->query("SELECT COUNT(*) AS count_orders FROM orders");
$ordersCount = $orders->fetch(PDO::FETCH_OBJ);

// Bookings
$bookings = $conn->query("SELECT COUNT(*) AS count_bookings FROM bookings");
$bookingsCount = $bookings->fetch(PDO::FETCH_OBJ);

// Admins
$admins = $conn->query("SELECT COUNT(*) AS count_admins FROM admins");
$adminsCount = $admins->fetch(PDO::FETCH_OBJ);
?>

<div class="row">
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Products</h5>
        <p class="card-text">number of products: <?php echo $productsCount->count_products; ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Orders</h5>
        <p class="card-text">number of orders: <?php echo $ordersCount->count_orders; ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Bookings</h5>
        <p class="card-text">number of bookings: <?php echo $bookingsCount->count_bookings; ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Admins</h5>
        <p class="card-text">number of admins: <?php echo $adminsCount->count_admins; ?></p>
      </div>
    </div>
  </div>
</div>

<?php require "layouts/footer.php"; ?>
