<?php
require __DIR__ . '/vendor/autoload.php'; // path to autoload.php

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..'); // adjust to project root
$dotenv->load();

// Get DB credentials from .env
$host    = $_ENV['DB_HOST'];
$db      = $_ENV['DB_NAME'];
$user    = $_ENV['DB_USER'];
$pass    = $_ENV['DB_PASS'];
$charset = $_ENV['DB_CHARSET'];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    PDO::ATTR_EMULATE_PREPARES   => false,                  
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo "Database connection failed: " . htmlspecialchars($e->getMessage());
    exit;
}