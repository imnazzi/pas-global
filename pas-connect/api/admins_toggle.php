<?php
session_start();
require_once __DIR__ . '/../app/models/Admin.php';
if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'master') { header('Location: ?page=login'); exit; }
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$active = isset($_POST['active']) ? (int)$_POST['active'] : 0;
if ($id) Admin::setActive($id, $active);
header('Location: ?page=admin_admins');
