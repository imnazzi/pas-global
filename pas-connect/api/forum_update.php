<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title = trim($_POST['title'] ?? '');
$body = trim($_POST['body'] ?? '');
if (!$id || !$title || !$body) { http_response_code(400); echo json_encode(['success'=>false,'error'=>'Missing params']); exit; }

$pdo = getPDO();
// fetch topic
$stmt = $pdo->prepare('SELECT * FROM forums WHERE id = :id LIMIT 1'); $stmt->execute(['id'=>$id]); $t = $stmt->fetch();
if (!$t) { http_response_code(404); echo json_encode(['success'=>false,'error'=>'Topic not found']); exit; }

// permission: author or admin
$allowed = false;
if (!empty($_SESSION['admin_id'])) $allowed = true;
if (!empty($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$t['author_user_id']) $allowed = true;
if (!$allowed) { http_response_code(403); echo json_encode(['success'=>false,'error'=>'Unauthorized']); exit; }

// update
$stmt = $pdo->prepare('UPDATE forums SET title = :t, body = :b WHERE id = :id');
$stmt->execute(['t'=>$title,'b'=>$body,'id'=>$id]);

echo json_encode(['success'=>true,'id'=>$id]);
