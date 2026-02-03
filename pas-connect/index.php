<?php
// PAS Connect - Front controller (very small router for initial scaffolding)
session_start();
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/app/helpers/i18n.php';

// Language switch: use ?lang=ms or ?lang=en
if (!empty($_GET['lang'])){
    set_locale($_GET['lang']);
    // redirect to same URL without lang param
    $url = strtok($_SERVER['REQUEST_URI'], '?');
    $qs = $_GET; unset($qs['lang']);
    $q = http_build_query($qs);
    header('Location: ' . $url . ($q ? '?' . $q : ''));
    exit;
}
// Basic routing by "page" query param. Expand to a proper router for production.
$page = $_GET['page'] ?? 'home';
if ($page === 'home') {
    require __DIR__ . '/app/views/home.php';
} elseif ($page === 'login') {
    require __DIR__ . '/app/views/auth/login.php';
} elseif ($page === 'register') {
    require __DIR__ . '/app/views/auth/register.php';
} elseif ($page === 'auth_register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/app/controllers/AuthController.php';
    $ctrl = new AuthController();
    $ctrl->register();
} elseif ($page === 'auth_login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simple auth POST endpoint
    require_once __DIR__ . '/app/controllers/AuthController.php';
    $ctrl = new AuthController();
    $ctrl->login();
} elseif ($page === 'logout') {
    require_once __DIR__ . '/app/controllers/AuthController.php';
    $ctrl = new AuthController();
    $ctrl->logout();
} elseif ($page === 'admin_dashboard') {
    // Admin dashboard placeholder
    require __DIR__ . '/app/views/admin/dashboard.php';
} elseif ($page === 'user_dashboard') {
    require __DIR__ . '/app/views/user/dashboard.php';
} elseif ($page === 'messages_inbox') {
    require_once __DIR__ . '/app/controllers/MessageController.php';
    $mc = new MessageController();
    $mc->inbox();
} elseif ($page === 'messages_view') {
    require_once __DIR__ . '/app/controllers/MessageController.php';
    $mc = new MessageController();
    $mc->viewConversation();
    // Tambah ini di index.php
} elseif ($page === 'messages') {
    // Jika anda mahu ia terus buka senarai mesej (Inbox)
    require_once __DIR__ . '/app/controllers/MessageController.php';
    $mc = new MessageController();
    $mc->inbox();
} elseif ($page === 'videos') {
    require_once __DIR__ . '/app/controllers/VideoController.php';
    $vc = new VideoController();
    $vc->index();
} elseif ($page === 'videos_view') {
    require_once __DIR__ . '/app/controllers/VideoController.php';
    $vc = new VideoController();
    $vc->view();
} elseif ($page === 'admin_videos') {
    require __DIR__ . '/app/views/admin/videos_list.php';
} elseif ($page === 'admin_videos_create') {
    require __DIR__ . '/app/views/admin/videos_create.php';
} elseif ($page === 'admin_admins') {
    require_once __DIR__ . '/app/controllers/AdminController.php'; $ac = new AdminController(); $ac->index();
} elseif ($page === 'admin_admins_create') {
    require_once __DIR__ . '/app/controllers/AdminController.php'; $ac = new AdminController(); $ac->create();
} elseif ($page === 'admin_admins_edit') {
    require_once __DIR__ . '/app/controllers/AdminController.php'; $ac = new AdminController(); $ac->edit();
} elseif ($page === 'community') {
    require_once __DIR__ . '/app/controllers/CommunityController.php';
    $cc = new CommunityController();
    $cc->index();
} elseif ($page === 'community_view') {
    require_once __DIR__ . '/app/controllers/CommunityController.php';
    $cc = new CommunityController();
    $cc->view();
} elseif ($page === 'admin_community_create') {
    require __DIR__ . '/app/views/admin/community_create.php';
    
} elseif ($page === 'forums') {
    require_once __DIR__ . '/app/controllers/ForumController.php';
    $fc = new ForumController();
    $fc->index();
} elseif ($page === 'forum_view') {
    require_once __DIR__ . '/app/controllers/ForumController.php';
    $fc = new ForumController();
    $fc->view();
} elseif ($page === 'admin_forums') {
    require __DIR__ . '/app/views/admin/forums_moderation.php';
} elseif ($page === 'calendar') {
    require_once __DIR__ . '/app/controllers/CalendarController.php';
    $cc = new CalendarController();
    $cc->index();
} elseif ($page === 'calendar_view') {
    require_once __DIR__ . '/app/controllers/CalendarController.php';
    $cc = new CalendarController();
    $cc->view();
} elseif ($page === 'admin_calendar_create') {
    require __DIR__ . '/app/views/admin/calendar_create.php';
} else {
    http_response_code(404);
    echo "<h1>404 - Page not found</h1>";
}
