<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../app/models/Notification.php';
$id = isset($_POST['id']) ? (int)$_POST['id'] : null;
if (!$id) { echo json_encode(['success'=>false]); exit; }
Notification::markAsRead($id);
echo json_encode(['success'=>true]);
