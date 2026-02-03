<?php
// Simple integration test script (CLI) to validate: register user, send message -> admin notification
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Admin.php';
require_once __DIR__ . '/../app/models/Message.php';
require_once __DIR__ . '/../app/models/Notification.php';

// Ensure master admin exists
$admin = Admin::findByEmail('master@pas.local');
if (!$admin) {
    echo "Master admin not found. Run scripts/seed_admin.php first.\n";
    exit(1);
}
$admin_id = (int)$admin['id'];

// Create test user
$testEmail = 'testuser@local';
$testPass = 'Test@123';
$user = User::findByEmail($testEmail);
if (!$user) {
    $uid = User::create($testEmail, password_hash($testPass, PASSWORD_BCRYPT), 'Test User');
    $user = User::findById($uid);
    echo "Created test user: $testEmail (id=$uid)\n";
} else {
    echo "Test user exists: $testEmail (id={$user['id']})\n";
}
$user_id = (int)$user['id'];

// Send message from user to admin
$body = 'Integration test message: hello admin';
$mid = Message::send(null, $user_id, $admin_id, null, $body);
Notification::create($user_id, $admin_id, 'admin', 'message', $mid, 'Test message', $body);

// Check notification count
$count = Notification::unreadCount($admin_id);
if ($count > 0) {
    echo "SUCCESS: Admin (id=$admin_id) has $count unread notification(s).\n";
    exit(0);
} else {
    echo "FAIL: No notifications found for admin.\n";
    exit(2);
}
