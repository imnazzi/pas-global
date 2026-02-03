<?php
// Seed the database with a Master Admin account.
require_once __DIR__ . '/../config/db.php';

try {
    $pdo = getPDO();
    $email = 'master@pas.local';
    $password = password_hash('Admin@123', PASSWORD_BCRYPT);
    $role = 'master';

    // Check if admin already exists
    $stmt = $pdo->prepare('SELECT id FROM admins WHERE email = :email');
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        echo "Master admin already exists: $email\n";
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO admins (email, password, role, created_at) VALUES (:email, :password, :role, NOW())');
    $stmt->execute(['email'=>$email, 'password'=>$password, 'role'=>$role]);
    echo "Master admin created: $email / Admin@123\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
