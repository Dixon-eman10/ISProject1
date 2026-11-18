<?php
// config/db.php
$host = '127.0.0.1';
$db   = 'isproject1_db';
$user = 'root';      // Update on Azure VM if using a dedicated DB user
$pass = 'YOUR_DB_PASSWORD';          // Update with your local / Azure MariaDB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    http_response_code(500);
    exit("Database connection error. Please try again later.");
}