<?php
require "layouts/header.php";    // includes session_start() and ADMINURL definition
require "../config/config.php";

// Check admin login
if (!isset($_SESSION['admin_name'])) {
    header("Location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

// Fetch counts from database using prepared statements
try {
    $productsStmt = $conn->query("SELECT COUNT(*) AS count_products FROM products");
    $productsCount = $productsStmt->fetch(PDO::FETCH_OBJ);

    $ordersStmt = $conn->query("SELECT COUNT(*) AS count_orders FROM orders");
    $ordersCount = $ordersStmt->fetch(PDO::FETCH_OBJ);

    $bookingsStmt = $conn->query("SELECT COUNT(*) AS count_bookings FROM bookings");
    $bookingsCount = $bookingsStmt->fetch(PDO::FETCH_OBJ);

    $adminsStmt = $conn->query("SELECT COUNT(*) AS count_admins FROM admins");
    $adminsCount = $adminsStmt->fetch(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Products</h5>
                <p class="card-text">Number of products: <?php echo $productsCount->count_products; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Orders</h5>
                <p class="card-text">Number of orders: <?php echo $ordersCount->count_orders; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Bookings</h5>
                <p class="card-text">Number of bookings: <?php echo $bookingsCount->count_bookings; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Admins</h5>
                <p class="card-text">Number of admins: <?php echo $adminsCount->count_admins; ?></p>
            </div>
        </div>
    </div>
</div>

<?php require "layouts/footer.php"; ?>
