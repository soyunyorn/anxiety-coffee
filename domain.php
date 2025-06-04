<?php
$Domain = $_SERVER['HTTP_HOST'];
if (strpos($Domain, "localhost") !== false) {
    define("APPURL", "http://localhost/anxiety-coffee/");
} else {
    define("APPURL", "https://maisreyneang.com/sreyneang/anxiety-coffee/");
}
// echo '<script>console.log("' . APPURL . '")</script>';
?>
