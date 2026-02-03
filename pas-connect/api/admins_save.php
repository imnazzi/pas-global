<?php
session_start();
require_once __DIR__ . '/../app/models/Admin.php';
if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'master') { header('Location: ?page=login'); exit; }

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$email = trim($_POST['email'] ?? '');
$pass = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'sub';
$active = isset($_POST['active']) ? 1 : 0;
if (!$email) { header('Location: ?page=admin_admins_create&error=1'); exit; }

$pdo = getPDO();
// unique email check
$stmt = $pdo->prepare('SELECT id FROM admins WHERE email = :email AND id != :id'); $stmt->execute(['email'=>$email,'id'=>$id]);
if ($stmt->fetch()) { header('Location: ?page=admin_admins_create&error=exists'); exit; }

if ($id) {
    $password_hash = $pass ? password_hash($pass, PASSWORD_BCRYPT) : null;
    Admin::update($id, $email, $role, $active, $password_hash);
} else {
    $password_hash = $pass ? password_hash($pass, PASSWORD_BCRYPT) : password_hash(bin2hex(random_bytes(4)), PASSWORD_BCRYPT);
    Admin::create($email, $password_hash, $role);
}

header('Location: ?page=admin_admins');
