<?php

require "../includes/header.php";
require "../config/config.php";

// Prevent direct access
if (!isset($_SERVER['HTTP_REFERER'])) {
    header('location: http://localhost/anxiety-coffee');
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("location: " . APPURL);
    exit;
}

// Delete all cart items for the user
$deleteAll = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
$deleteAll->execute([
    ':user_id' => $_SESSION['user_id']
]);

// Redirect to cart page
header("location: cart.php");
exit;
