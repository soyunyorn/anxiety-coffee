<?php
session_start();

$host = $_SERVER['HTTP_HOST'];

if ($host === 'localhost') {
    // Local setup
    define("DB_HOST", "127.0.0.1");
    define("DB_NAME", "anxiety_db");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("APPURL", "http://localhost/anxiety-coffee/");
} else {
    // Live server setup
    define("DB_HOST", "localhost");
    define("DB_NAME", "e4g6wad_anxiety_db");
    define("DB_USER", "e4g6wad_anxiety_user");
    define("DB_PASS", "H#K7bkh2*gq=");
    define("APPURL", "https://maisreyneang.com/sreyneang/anxiety-coffee/");
}

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // optional debug
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
