<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../app/models/Notification.php';
$rid = null;
if (!empty($_SESSION['admin_id'])) $rid = (int)$_SESSION['admin_id'];
elseif (!empty($_SESSION['user_id'])) $rid = (int)$_SESSION['user_id'];
else { echo json_encode(['success'=>false, 'items'=>[]]); exit; }
$items = Notification::listForReceiver($rid, 30);
// Return items (client can map type to URL)
echo json_encode(['success'=>true, 'items'=>$items]);
