<?php
require_once __DIR__ . '/../../config/db.php';

class Video {
    public static function all() {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT v.*, a.email as uploader_email FROM videos v LEFT JOIN admins a ON v.uploader_admin_id = a.id ORDER BY created_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public static function find($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT v.*, a.email as uploader_email FROM videos v LEFT JOIN admins a ON v.uploader_admin_id = a.id WHERE v.id = :id LIMIT 1');
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch();
    }
}
