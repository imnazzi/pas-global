<?php
// Database configuration for XAMPP local environment
// Update DB_USER/DB_PASS if your local setup differs

define('DB_HOST', 'localhost');
define('DB_NAME', 'pas_connect');
define('DB_USER', 'root');
define('DB_PASS', '');

function getPDO(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;
    // Use localhost (socket) for XAMPP/MAMP environments if TCP fails
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    return $pdo;
}
