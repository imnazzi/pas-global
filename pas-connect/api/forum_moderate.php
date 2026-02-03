<?php
session_start();
require_once __DIR__ . '/../app/models/Notification.php';
if (empty($_SESSION['admin_id'])) { header('Location: ?page=login'); exit; }
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
action = $_POST['action'] ?? '';
$pdo = getPDO();
if (!$id) { header('Location: ?page=admin_forums'); exit; }
if ($action === 'close') {
    $stmt = $pdo->prepare('UPDATE forums SET is_closed = 1 WHERE id = :id'); $stmt->execute(['id'=>$id]);
    // notify topic author
    $stmt = $pdo->prepare('SELECT author_user_id, title FROM forums WHERE id = :id LIMIT 1'); $stmt->execute(['id'=>$id]); $t = $stmt->fetch();
    if ($t && $t['author_user_id']) Notification::create($_SESSION['admin_id'], $t['author_user_id'], 'user', 'forum', $id, 'Your forum topic was closed', $t['title']);
} elseif ($action === 'open') {
    $stmt = $pdo->prepare('UPDATE forums SET is_closed = 0 WHERE id = :id'); $stmt->execute(['id'=>$id]);
} elseif ($action === 'delete') {
    // notify author
    $stmt = $pdo->prepare('SELECT author_user_id, title FROM forums WHERE id = :id LIMIT 1'); $stmt->execute(['id'=>$id]); $t = $stmt->fetch();
    if ($t && $t['author_user_id']) Notification::create($_SESSION['admin_id'], $t['author_user_id'], 'user', 'forum', $id, 'Your forum topic was deleted', $t['title']);
    $stmt = $pdo->prepare('DELETE FROM forums WHERE id = :id'); $stmt->execute(['id'=>$id]);
}
header('Location: ?page=admin_forums');
