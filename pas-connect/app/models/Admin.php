<?php
// Admin model (simple, using PDO). In production, add proper error handling and more methods.
require_once __DIR__ . '/../../config/db.php';

class Admin {
    public static function findByEmail(string $email) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public static function create($email, $password_hash, $role = 'sub') {
        $pdo = getPDO();
        $stmt = $pdo->prepare('INSERT INTO admins (email, password, role, is_active, created_at) VALUES (:email, :password, :role, 1, NOW())');
        $stmt->execute(['email'=>$email, 'password'=>$password_hash, 'role'=>$role]);
        return $pdo->lastInsertId();
    }

    public static function all() {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM admins ORDER BY created_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE id = :id LIMIT 1');
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch();
    }

    public static function update($id, $email, $role, $is_active, $password_hash = null) {
        $pdo = getPDO();
        if ($password_hash) {
            $stmt = $pdo->prepare('UPDATE admins SET email = :email, role = :role, is_active = :active, password = :password WHERE id = :id');
            $stmt->execute(['email'=>$email, 'role'=>$role, 'active'=>$is_active, 'password'=>$password_hash, 'id'=>$id]);
        } else {
            $stmt = $pdo->prepare('UPDATE admins SET email = :email, role = :role, is_active = :active WHERE id = :id');
            $stmt->execute(['email'=>$email, 'role'=>$role, 'active'=>$is_active, 'id'=>$id]);
        }
        return $stmt->rowCount();
    }

    public static function delete($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('DELETE FROM admins WHERE id = :id');
        $stmt->execute(['id'=>$id]);
        return $stmt->rowCount();
    }

    public static function setActive($id, $active) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('UPDATE admins SET is_active = :active WHERE id = :id');
        $stmt->execute(['active'=>$active ? 1 : 0, 'id'=>$id]);
        return $stmt->rowCount();
    }
}
