<?php
// Seed Master + 3 Sub Admins (if they don't already exist)
require_once __DIR__ . '/../config/db.php';

$admins = [
    ['email' => 'master@pasglobalconnect.com', 'password' => 'password', 'role' => 'master'],
    ['email' => 'admin1@pasglobalconnect.com', 'password' => 'password', 'role' => 'sub'],
    ['email' => 'admin2@pasglobalconnect.com', 'password' => 'password', 'role' => 'sub'],
    ['email' => 'admin3@pasglobalconnect.com', 'password' => 'password', 'role' => 'sub'],
];

try {
    $pdo = getPDO();
    foreach ($admins as $a) {
        $stmt = $pdo->prepare('SELECT id FROM admins WHERE email = :email');
        $stmt->execute(['email' => $a['email']]);
        if ($stmt->fetch()) {
            echo "Admin exists: {$a['email']}\n";
            continue;
        }
        $hash = password_hash($a['password'], PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('INSERT INTO admins (email, password, role, created_at) VALUES (:email, :password, :role, NOW())');
        $stmt->execute(['email' => $a['email'], 'password' => $hash, 'role' => $a['role']]);
        echo "Created admin: {$a['email']} / {$a['password']} ({$a['role']})\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
