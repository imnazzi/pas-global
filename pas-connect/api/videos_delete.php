<?php
session_start();
if (empty($_SESSION['admin_id'])) { header('Location: ?page=login'); exit; }
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!$id) { header('Location: ?page=admin_videos'); exit; }
$pdo = getPDO();
$stmt = $pdo->prepare('SELECT filename, thumbnail FROM videos WHERE id = :id LIMIT 1'); $stmt->execute(['id'=>$id]); $v = $stmt->fetch();
if ($v) {
    if (!empty($v['filename']) && file_exists(__DIR__ . '/../uploads/videos/' . $v['filename'])) unlink(__DIR__ . '/../uploads/videos/' . $v['filename']);
    if (!empty($v['thumbnail']) && file_exists(__DIR__ . '/../uploads/videos/' . $v['thumbnail'])) unlink(__DIR__ . '/../uploads/videos/' . $v['thumbnail']);
    $stmt = $pdo->prepare('DELETE FROM videos WHERE id = :id'); $stmt->execute(['id'=>$id]);
}
header('Location: ?page=admin_videos');
