<?php
require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    // Only Master admin may manage other admins
    private static function requireMaster() {
        if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'master') {
            header('Location: ?page=login'); exit;
        }
    }

    public function index() {
        self::requireMaster();
        $admins = Admin::all();
        require __DIR__ . '/../views/admin/admins_list.php';
    }

    public function create() {
        self::requireMaster();
        require __DIR__ . '/../views/admin/admins_create.php';
    }

    public function edit() {
        self::requireMaster();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (!$id) { header('Location: ?page=admin_admins'); exit; }
        $admin = Admin::findById($id);
        require __DIR__ . '/../views/admin/admins_create.php';
    }
}
