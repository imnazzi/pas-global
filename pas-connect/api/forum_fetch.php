<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../app/models/Forum.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { http_response_code(400); echo json_encode(['success'=>false,'error'=>'Missing id']); exit; }
$t = Forum::find($id);
$replies = Forum::replies($id);
if (!$t) { http_response_code(404); echo json_encode(['success'=>false,'error'=>'Not found']); exit; }

echo json_encode(['success'=>true,'topic'=>$t,'replies'=>$replies]);
