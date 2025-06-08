<?php
ob_start();

require "../includes/header.php";
require "../config/config.php";

if (isset($_POST['submit'])) {
    if (
        empty($_POST['first_name']) || empty($_POST['last_name']) ||
        empty($_POST['date']) || empty($_POST['time']) ||
        empty($_POST['phone']) || empty($_POST['message'])
    ) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('You must be logged in to book.');</script>";
            exit();
        }

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
        $user_id = $_SESSION['user_id'];

        $inputDate = DateTime::createFromFormat('n/j/Y', $date);
        $today = new DateTime();
        $today->setTime(0, 0, 0);

        // Debug to check inputDate
        // var_dump($inputDate, $date);

        if ($inputDate && $inputDate > $today) {
            $insert = $conn->prepare("INSERT INTO bookings (first_name, last_name, date, time, phone, message, user_id) 
                VALUES (:first_name, :last_name, :date, :time, :phone, :message, :user_id)");
            $insert->execute([
                ":first_name" => $first_name,
                ":last_name" => $last_name,
                ":date" => $date,
                ":time" => $time,
                ":phone" => $phone,
                ":message" => $message,
                ":user_id" => $user_id
            ]);

            header("Location: https://maisreyneang.com/sreyneang/anxiety-coffee/");
            exit();
        } else {
            echo "<script>alert('The booking date must be in the future.');</script>";
        }
    }
}

ob_end_flush();
?>
