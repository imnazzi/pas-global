<?php
require_once __DIR__ . '/../../config/db.php';

class Forum {
    // Returns forum topics with author email and reply counts
    public static function all(){
        $pdo = getPDO();
        $stmt = $pdo->prepare(
            'SELECT f.*, u.email AS creator_email, COALESCE(COUNT(r.id),0) AS replies_count '
            . 'FROM forums f '
            . 'LEFT JOIN users u ON f.author_user_id = u.id '
            . 'LEFT JOIN forum_replies r ON r.forum_id = f.id '
            . 'GROUP BY f.id ORDER BY f.created_at DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Find a single topic with author details
    public static function find($id){
        $pdo = getPDO();
        $stmt = $pdo->prepare(
            'SELECT f.*, u.email AS creator_email, u.name AS creator_name '
            . 'FROM forums f '
            . 'LEFT JOIN users u ON f.author_user_id = u.id '
            . 'WHERE f.id = :id LIMIT 1'
        );
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch();
    }

    // Get replies for a forum topic with author info
    public static function replies($forum_id){
        $pdo = getPDO();
        $stmt = $pdo->prepare(
            'SELECT r.*, u.email AS author_email, u.name AS author_name '
            . 'FROM forum_replies r '
            . 'LEFT JOIN users u ON r.author_user_id = u.id '
            . 'WHERE r.forum_id = :id ORDER BY r.created_at ASC'
        );
        $stmt->execute(['id'=>$forum_id]);
        return $stmt->fetchAll();
    }
}
