<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

$forum_id = isset($_POST['forum_id']) ? (int)$_POST['forum_id'] : 0;
$body = trim($_POST['body'] ?? '');
if (!$forum_id || !$body) { http_response_code(400); echo json_encode(['success'=>false,'error'=>'Missing params']); exit; }
if (empty($_SESSION['user_id'])) { http_response_code(403); echo json_encode(['success'=>false,'error'=>'Not authenticated']); exit; }
$user_id = (int)$_SESSION['user_id'];

$pdo = getPDO();
$stmt = $pdo->prepare('INSERT INTO forum_replies (forum_id, author_user_id, body, created_at) VALUES (:f,:u,:b,NOW())');
$stmt->execute(['f'=>$forum_id,'u'=>$user_id,'b'=>$body]);
$id = $pdo->lastInsertId();

echo json_encode(['success'=>true,'id'=>$id]);
