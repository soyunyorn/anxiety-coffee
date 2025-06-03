<?php
try {
    // ✅ Use these correct values for your live server
    $host = 'localhost'; // usually stays localhost
    $dbname = 'e4g6wad_anxiety_db'; // your real database name
    $user = 'anxiety_user'; // your real database user
    $pass = 'H#K7bkh2*gq='; // your real database password

    // ✅ Create PDO connection using the correct variables
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connected successfully"; // for debugging
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

   
