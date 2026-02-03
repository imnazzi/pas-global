<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../app/models/Forum.php';
$topics = Forum::all();
echo json_encode(['success'=>true,'items'=>$topics]);
