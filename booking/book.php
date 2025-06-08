<?php
require "../includes/header.php"; // Make sure session_start() is here
require "../config/config.php";

if (isset($_POST['submit'])) {

    if (
        empty($_POST['first_name']) || empty($_POST['last_name']) ||
        empty($_POST['date']) || empty($_POST['time']) ||
        empty($_POST['phone']) || empty($_POST['message'])
    ) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
        $user_id = $_SESSION['user_id'];

        // Convert date input to DateTime object
        $inputDate = DateTime::createFromFormat('n/j/Y', $date);
        $today = new DateTime();
        $today->setTime(0, 0, 0);  // Compare only date part

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

            // Redirect to homepage after successful booking
            header("Location: https://maisreyneang.com/sreyneang/anxiety-coffee/");
            exit();
        } else {
            echo "<script>alert('The booking date must be in the future.');</script>";
        }
    }
}
?>
