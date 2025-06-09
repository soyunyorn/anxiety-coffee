<?php 
ob_start(); // Start output buffering to allow header() redirects
require "../includes/header.php"; 
require "../config/config.php"; 

if (!isset($_SESSION['user_id'])) {
    header("location: " . APPURL . "");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statements for security
    $delete = $conn->prepare("DELETE FROM cart WHERE id = :id AND user_id = :user_id");
    $delete->execute([
        ":id" => $id,
        ":user_id" => $_SESSION['user_id']
    ]);

    header("Location: cart.php");
    exit;
}

ob_end_flush(); // Send the buffered output
?>
