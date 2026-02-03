<?php
// Notification model: create/mark/read helper methods
require_once __DIR__ . '/../../config/db.php';

class Notification {
    public static function create($sender_id, $receiver_id, $role, $type, $reference_id, $title, $message) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO notifications (sender_id, receiver_id, role, type, reference_id, title, message, is_read, created_at) VALUES (:s, :r, :role, :type, :ref, :title, :msg, 0, NOW())");
        $stmt->execute(['s'=>$sender_id, 'r'=>$receiver_id, 'role'=>$role, 'type'=>$type, 'ref'=>$reference_id, 'title'=>$title, 'msg'=>$message]);
        return $pdo->lastInsertId();
    }

    // Count unread notifications for a recipient. Includes broadcasts (receiver_id = 0) matching role.
    public static function unreadCount($receiver_id, $role = null) {
        $pdo = getPDO();
        if ($role) {
            $stmt = $pdo->prepare('SELECT COUNT(*) as c FROM notifications WHERE (receiver_id = :rid OR receiver_id = 0) AND role = :role AND is_read = 0');
            $stmt->execute(['rid'=>$receiver_id, 'role'=>$role]);
        } else {
            $stmt = $pdo->prepare('SELECT COUNT(*) as c FROM notifications WHERE (receiver_id = :rid OR receiver_id = 0) AND is_read = 0');
            $stmt->execute(['rid'=>$receiver_id]);
        }
        $row = $stmt->fetch();
        return $row ? (int)$row['c'] : 0;
    }

    // List notifications visible to receiver (include broadcasts where receiver_id=0 and matching role)
    public static function listForReceiver($receiver_id, $role = null, $limit = 20) {
        $pdo = getPDO();
        if ($role) {
            $stmt = $pdo->prepare('SELECT * FROM notifications WHERE (receiver_id = :rid OR receiver_id = 0) AND role = :role ORDER BY created_at DESC LIMIT :lim');
            $stmt->bindValue(':rid', $receiver_id, PDO::PARAM_INT);
            $stmt->bindValue(':role', $role);
            $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $pdo->prepare('SELECT * FROM notifications WHERE (receiver_id = :rid OR receiver_id = 0) ORDER BY created_at DESC LIMIT :lim');
            $stmt->bindValue(':rid', $receiver_id, PDO::PARAM_INT);
            $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
        }
        return $stmt->fetchAll();
    }

    public static function markAsRead($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('UPDATE notifications SET is_read = 1 WHERE id = :id');
        $stmt->execute(['id'=>$id]);
        return $stmt->rowCount();
    }

    public static function markAllRead($receiver_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('UPDATE notifications SET is_read = 1 WHERE receiver_id = :rid OR receiver_id = 0');
        $stmt->execute(['rid'=>$receiver_id]);
        return $stmt->rowCount();
    }
}
