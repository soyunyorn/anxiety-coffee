<?php
$Domain = $_SERVER['HTTP_HOST'];
if (strpos($Domain, "localhost") !== false) { //stringPos is a function that returns the position of a string
    define("APPURL", "http://localhost/anxiety-coffee/"); //localhost/hotelbooking
}
else {
    define("APPURL", "https://maisreyneang.com/sreyneang/anxiety-coffee/"); //www.example.com
}
// echo '<script>console.log("' . APP_URL . '")</script>';
?>
