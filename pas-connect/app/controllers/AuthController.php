<?php
// Simple Auth controller scaffold - extend with proper validation and session security
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function register() {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $name = trim($_POST['name'] ?? null);
        if (!$email || !$password || $password !== $password_confirm) {
            header('Location: ?page=register&error=1');
            exit;
        }
        if (User::findByEmail($email)) {
            header('Location: ?page=register&error=exists');
            exit;
        }
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $uid = User::create($email, $hash, $name);
        // auto-login
        session_regenerate_id(true);
        $_SESSION['user_id'] = $uid;
        $_SESSION['role'] = 'user';
        header('Location: ?page=user_dashboard');
        exit;
    }

    public function login() {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if (!$email || !$password) {
            header('Location: ?page=login&error=1');
            exit;
        }
        // Check admin first
        $admin = Admin::findByEmail($email);
        if ($admin && password_verify($password, $admin['password'])) {
            // regenerate session ID for security
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['role'] = 'admin';
            $_SESSION['admin_role'] = $admin['role'];
            header('Location: ?page=admin_dashboard');
            exit;
        }
        // Check user
        require_once __DIR__ . '/../models/User.php';
        $user = User::findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = 'user';
            header('Location: ?page=user_dashboard');
            exit;
        }
        header('Location: ?page=login&error=1');
    }

    public function logout() {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'], $params['secure'], $params['httponly']
            );
        }
        session_destroy();
        header('Location: ?page=home');
        exit;
    }
}
