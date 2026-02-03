<?php
require_once __DIR__ . '/../../config/db.php';

class Community {
    // Return posts with uploader email (admin or user)
    public static function all(){
        $pdo = getPDO();
        $stmt = $pdo->prepare(
            'SELECT p.*, COALESCE(a.email, u.email) AS uploader_email '
            . 'FROM community_posts p '
            . 'LEFT JOIN admins a ON p.author_admin_id = a.id '
            . 'LEFT JOIN users u ON p.author_user_id = u.id '
            . 'ORDER BY p.created_at DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public static function find($id){
        $pdo = getPDO();
        $stmt = $pdo->prepare(
            'SELECT p.*, COALESCE(a.email, u.email) AS uploader_email '
            . 'FROM community_posts p '
            . 'LEFT JOIN admins a ON p.author_admin_id = a.id '
            . 'LEFT JOIN users u ON p.author_user_id = u.id '
            . 'WHERE p.id = :id LIMIT 1'
        );
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch();
    }
}
