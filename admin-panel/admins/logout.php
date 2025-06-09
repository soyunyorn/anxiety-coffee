<?php
// Start the session
session_start();

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page on your live server
header("Location: https://maisreyneang.com/sreyneang/anxiety-coffee/admin-panel/admins/login-admins.php");
exit;
?>
