<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

if (empty($_SESSION['user_id'])) { http_response_code(403); echo json_encode(['success'=>false,'error'=>'Not authenticated']); exit; }
$user_id = (int)$_SESSION['user_id'];

$title = trim($_POST['title'] ?? '');
$body = trim($_POST['body'] ?? '');
if (!$title || !$body) { http_response_code(400); echo json_encode(['success'=>false,'error'=>'Missing params']); exit; }

$pdo = getPDO();
$stmt = $pdo->prepare('INSERT INTO forums (author_user_id, title, body, created_at) VALUES (:u,:t,:b,NOW())');
$stmt->execute(['u'=>$user_id,'t'=>$title,'b'=>$body]);
$id = $pdo->lastInsertId();

echo json_encode(['success'=>true,'id'=>$id]);
