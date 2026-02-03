<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../app/models/Notification.php';
$rid = null; $role = null;
if (!empty($_SESSION['admin_id'])) { $rid = (int)$_SESSION['admin_id']; $role='admin'; }
elseif (!empty($_SESSION['user_id'])) { $rid = (int)$_SESSION['user_id']; $role='user'; }
else { echo json_encode(['success'=>false,'count'=>0]); exit; }
$count = Notification::unreadCount($rid, $role);
echo json_encode(['success'=>true, 'count'=>$count]);
