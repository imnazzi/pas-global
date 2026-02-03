<?php
require_once __DIR__ . '/../../config/db.php';

class CalendarEvent {
    public static function all(){
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT ce.*, a.email as creator_email FROM calendar_events ce LEFT JOIN admins a ON ce.creator_admin_id = a.id ORDER BY start_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public static function find($id){
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT ce.*, a.email as creator_email FROM calendar_events ce LEFT JOIN admins a ON ce.creator_admin_id = a.id WHERE ce.id = :id LIMIT 1');
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch();
    }
}
