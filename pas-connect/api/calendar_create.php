<?php
session_start();
require_once __DIR__ . '/../app/models/Notification.php';
if (empty($_SESSION['admin_id'])) { header('Location: ?page=login'); exit; }
$admin_id = (int)$_SESSION['admin_id'];
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
// Normalize datetimes from HTML input (datetime-local uses 'YYYY-MM-DDTHH:MM')
$start_at_raw = trim($_POST['start_at'] ?? '');
$end_at_raw = isset($_POST['end_at']) ? trim($_POST['end_at']) : '';
$start_at = $start_at_raw ? str_replace('T', ' ', $start_at_raw) : '';
$end_at = $end_at_raw !== '' ? str_replace('T', ' ', $end_at_raw) : null;
if (!$title || !$start_at) { header('Location: ?page=admin_calendar_create&error=1'); exit; }
try {
    $pdo = getPDO();
    $stmt = $pdo->prepare('INSERT INTO calendar_events (creator_admin_id, title, description, start_at, end_at, created_at) VALUES (:c, :t, :d, :s, :e, NOW())');
    $stmt->execute(['c'=>$admin_id,'t'=>$title,'d'=>$description,'s'=>$start_at,'e'=>$end_at]);
    $eid = $pdo->lastInsertId();
    // Broadcast to users
    Notification::create($admin_id, 0, 'user', 'calendar', $eid, $title, substr($description,0,200));
    header('Location: ?page=calendar');
    exit;
} catch (Exception $e) {
    // Log the error for debugging and return to form with an error flag
    error_log('calendar_create error: ' . $e->getMessage());
    // include more context in log
    error_log('calendar_create context: admin_id='.$admin_id.' title='.substr($title,0,100).' start_at='.$start_at);
    // Also write to a temporary debug file for easy inspection during development
    file_put_contents('/tmp/calendar_create_debug.log', date('c') . " - " . $e->getMessage() . "\nContext: admin_id=$admin_id title=" . substr($title,0,200) . " start_at=$start_at\n\n", FILE_APPEND);
    header('Location: ?page=admin_calendar_create&error=server');
    exit;
}
