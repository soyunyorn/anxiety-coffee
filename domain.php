<?php
$Domain = $_SERVER['HTTP_HOST'];
if (strpos($Domain, "localhost") !== false) { //stringPos is a function that returns the position of a string
    define("APP_URL", "http://localhost/anxiety-coffee/"); //localhost/hotelbooking
}
else {
    define("APP_URL", "https://maisreyneang.com/anxiety-coffee/"); //www.example.com
}
// echo '<script>console.log("' . APP_URL . '")</script>';
?>
