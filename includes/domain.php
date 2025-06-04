<?php
$Domain = $_SERVER['HTTP_HOST'];
if (strpos($Domain, "localhost") !== false) {
    define("APPURL", "/anxiety-coffee/");
    define("IMAGEPRODUCTS", "/anxiety-coffee/admin-panel/products-admins/images");
} else {
    define("APPURL", "https://maisreyneang.com/sreyneang/anxiety-coffee");
    define("IMAGEPRODUCTS", "https://maisreyneang.com/sreyneang/anxiety-coffee/admin-panel/products-admins/images");


}
// echo '<script>console.log("' . APPURL . '")</script>';
?>
