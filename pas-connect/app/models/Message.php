<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/Notification.php';

class Message {
    // Send a message. Use sender/receiver admin_id or user_id depending on who sends.
    public static function send($sender_admin_id, $sender_user_id, $receiver_admin_id, $receiver_user_id, $body) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('INSERT INTO messages (sender_admin_id, sender_user_id, receiver_admin_id, receiver_user_id, body, is_read, created_at) VALUES (:sa, :su, :ra, :ru, :body, 0, NOW())');
        $stmt->execute([
            'sa' => $sender_admin_id,
            'su' => $sender_user_id,
            'ra' => $receiver_admin_id,
            'ru' => $receiver_user_id,
            'body' => $body
        ]);
        return $pdo->lastInsertId();
    }

    // Get conversations for an admin (list by user and last message)
    public static function getConversationsForAdmin($admin_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT m.*, u.id as user_id, u.email, u.name FROM messages m
            LEFT JOIN users u ON (m.sender_user_id = u.id OR m.receiver_user_id = u.id)
            WHERE m.sender_admin_id = :aid OR m.receiver_admin_id = :aid
            GROUP BY user_id
            ORDER BY MAX(m.created_at) DESC");
        $stmt->execute(['aid' => $admin_id]);
        return $stmt->fetchAll();
    }

    // Get conversations for a user (list by admin)
    public static function getConversationsForUser($user_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT m.*, a.id as admin_id, a.email as admin_email, a.role as admin_role FROM messages m
            LEFT JOIN admins a ON (m.sender_admin_id = a.id OR m.receiver_admin_id = a.id)
            WHERE m.sender_user_id = :uid OR m.receiver_user_id = :uid
            GROUP BY admin_id
            ORDER BY MAX(m.created_at) DESC");
        $stmt->execute(['uid' => $user_id]);
        return $stmt->fetchAll();
    }

    // Get full conversation messages between admin and user
    public static function getConversation($admin_id, $user_id, $limit = 100) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM messages WHERE (sender_admin_id = :aid AND receiver_user_id = :uid) OR (sender_user_id = :uid AND receiver_admin_id = :aid) ORDER BY created_at ASC LIMIT :lim');
        $stmt->bindValue(':aid', $admin_id, PDO::PARAM_INT);
        $stmt->bindValue(':uid', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Mark messages as read for a particular conversation for the receiver
    public static function markAsReadForReceiver($receiver_admin_id, $receiver_user_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('UPDATE messages SET is_read = 1 WHERE receiver_admin_id = :raid AND receiver_user_id = :ruid');
        $stmt->execute(['raid' => $receiver_admin_id, 'ruid' => $receiver_user_id]);
        return $stmt->rowCount();
    }
}
