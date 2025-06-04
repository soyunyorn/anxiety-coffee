<?php
session_start();
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        throw new Exception(".env file not found");
    }
    
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        $_ENV[$key] = $value;
    }
}

try {
    loadEnv(__DIR__ . '/.env');
    
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        define("DB_HOST", $_ENV['DB_HOST_LOCAL']);
        define("DB_NAME", $_ENV['DB_NAME_LOCAL']);
        define("DB_USER", $_ENV['DB_USER_LOCAL']);
        define("DB_PASS", $_ENV['DB_PASS_LOCAL']);
    } else {
        define("DB_HOST", $_ENV['DB_HOST_PROD']);
        define("DB_NAME", $_ENV['DB_NAME_PROD']);
        define("DB_USER", $_ENV['DB_USER_PROD']);
        define("DB_PASS", $_ENV['DB_PASS_PROD']);
    }
    
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // if ($pdo == true) {
    //     echo "Connected successfully";
    // } else {
    //     echo "Connection failed: ";
    // }
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

