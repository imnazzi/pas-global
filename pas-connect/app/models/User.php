<?php
require_once __DIR__ . '/../../config/db.php';

class User {
    public static function create($email, $password_hash, $name = null) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('INSERT INTO users (email, password, name, created_at) VALUES (:email, :password, :name, NOW())');
        $stmt->execute(['email' => $email, 'password' => $password_hash, 'name' => $name]);
        return $pdo->lastInsertId();
    }

    public static function findByEmail($email) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public static function findById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
