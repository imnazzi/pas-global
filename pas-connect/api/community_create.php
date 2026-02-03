<?php
session_start();
require_once __DIR__ . '/../app/models/Notification.php';
if (empty($_SESSION['admin_id'])) { header('Location: ?page=login'); exit; }
$admin_id = (int)$_SESSION['admin_id'];
$title = trim($_POST['title'] ?? '');
$body = trim($_POST['body'] ?? '');
$announcement = isset($_POST['announcement']) ? 1 : 0;
if (!$title || !$body) { header('Location: ?page=admin_community_create&error=1'); exit; }

$imageName = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $img = $_FILES['image'];
    $imageName = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/','_', basename($img['name']));
    move_uploaded_file($img['tmp_name'], __DIR__ . '/../uploads/community_images/' . $imageName);
}
$pdo = getPDO();
$stmt = $pdo->prepare('INSERT INTO community_posts (author_admin_id, title, body, is_announcement, created_at) VALUES (:a, :t, :b, :ann, NOW())');
$stmt->execute(['a'=>$admin_id,'t'=>$title,'b'=>$body,'ann'=>$announcement]);
$pid = $pdo->lastInsertId();

// Broadcast notification to users
Notification::create($admin_id, 0, 'user', 'community', $pid, $title, substr($body,0,200));

// If AJAX / JSON request, return JSON, else redirect
$accept = $_SERVER['HTTP_ACCEPT'] ?? '';
$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') || stripos($accept, 'application/json') !== false;
if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>true, 'post_id'=>$pid, 'image'=>$imageName]);
    exit;
}

header('Location: ?page=community');
