<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/models/Video.php';
require_once __DIR__ . '/../app/models/Notification.php';
require_once __DIR__ . '/../app/models/Admin.php';

if (empty($_SESSION['admin_id'])) { http_response_code(403); echo json_encode(['success'=>false,'error'=>'Unauthorized']); exit; }
$admin_id = (int)$_SESSION['admin_id'];

$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$publish = isset($_POST['publish']) ? 1 : 0;
if (!$title || !isset($_FILES['video'])) { http_response_code(400); echo json_encode(['success'=>false,'error'=>'Missing parameters']); exit; }
$video = $_FILES['video'];
if ($video['error'] !== UPLOAD_ERR_OK) { http_response_code(400); echo json_encode(['success'=>false,'error'=>'Upload error']); exit; }
// Validate type and size
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $video['tmp_name']);
if ($mime !== 'video/mp4') { http_response_code(400); echo json_encode(['success'=>false,'error'=>'Only MP4 allowed']); exit; }
// move file
$dstName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/','_', basename($video['name']));
$dstPath = __DIR__ . '/../uploads/videos/' . $dstName;
if (!move_uploaded_file($video['tmp_name'], $dstPath)) { http_response_code(500); echo json_encode(['success'=>false,'error'=>'Unable to save file']); exit; }

$thumbnailName = null;
if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
    $img = $_FILES['thumbnail'];
    $imgName = time().'_thumb_'.preg_replace('/[^a-zA-Z0-9._-]/','_', basename($img['name']));
    $imgPath = __DIR__ . '/../uploads/videos/' . $imgName;
    move_uploaded_file($img['tmp_name'], $imgPath);
    $thumbnailName = $imgName;
}

// Store in DB
$pdo = getPDO();
$stmt = $pdo->prepare('INSERT INTO videos (uploader_admin_id, title, description, filename, thumbnail, is_published, created_at) VALUES (:u, :t, :d, :f, :thumb, :pub, NOW())');
$stmt->execute(['u'=>$admin_id, 't'=>$title, 'd'=>$description, 'f'=>$dstName, 'thumb'=>$thumbnailName, 'pub'=>$publish]);
$vid = $pdo->lastInsertId();

// Broadcast notification to users if published
if ($publish) {
    Notification::create($admin_id, 0, 'user', 'video', $vid, 'New video uploaded', $title);
}

// Return success and redirect to admin videos list page
echo json_encode(['success'=>true, 'video_id'=>$vid]);
