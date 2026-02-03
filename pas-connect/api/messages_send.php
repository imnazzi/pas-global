<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../app/models/Message.php';
require_once __DIR__ . '/../app/models/Notification.php';

$body = trim($_POST['body'] ?? '');
$to_user_id = isset($_POST['to_user_id']) ? (int)$_POST['to_user_id'] : null;
$to_admin_id = isset($_POST['to_admin_id']) ? (int)$_POST['to_admin_id'] : null;
if (empty($body) || (!$to_user_id && !$to_admin_id)) {
    http_response_code(400);
    echo json_encode(['success'=>false, 'error'=>'Missing params']);
    exit;
}
try {
    if (!empty($_SESSION['admin_id'])) {
        $sid = (int)$_SESSION['admin_id'];
        $mid = Message::send($sid, null, $to_admin_id ?: null, $to_user_id ?: null, $body);
        if ($to_user_id) Notification::create($sid, $to_user_id, 'user', 'message', $mid, 'New message from Admin', substr($body,0,200));
    } elseif (!empty($_SESSION['user_id'])) {
        $sid = (int)$_SESSION['user_id'];
        $mid = Message::send(null, $sid, $to_admin_id ?: null, $to_user_id ?: null, $body);
        if ($to_admin_id) Notification::create($sid, $to_admin_id, 'admin', 'message', $mid, 'New message from User', substr($body,0,200));
    } else {
        http_response_code(403);
        echo json_encode(['success'=>false, 'error'=>'Not authenticated']);
        exit;
    }
    echo json_encode(['success'=>true, 'message_id'=>$mid]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success'=>false, 'error'=>$e->getMessage()]);
}
