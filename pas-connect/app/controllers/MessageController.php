<?php
require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Admin.php';

class MessageController {
    // Send message (from logged-in user/admin)
    public function send() {
        // Determine sender (admin or user)
        $body = trim($_POST['body'] ?? '');
        $to_user_id = isset($_POST['to_user_id']) ? (int)$_POST['to_user_id'] : null;
        $to_admin_id = isset($_POST['to_admin_id']) ? (int)$_POST['to_admin_id'] : null;
        if (empty($body) || (!$to_user_id && !$to_admin_id)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing params']);
            exit;
        }

        // If current session is admin
        if (!empty($_SESSION['admin_id'])) {
            $sender_admin_id = (int)$_SESSION['admin_id'];
            $sender_user_id = null;
            $receiver_admin_id = $to_admin_id ?: null;
            $receiver_user_id = $to_user_id ?: null;
            $mid = Message::send($sender_admin_id, null, $receiver_admin_id, $receiver_user_id, $body);

            // create notification for receiver user (if user exists)
            if ($receiver_user_id) {
                Notification::create($sender_admin_id, $receiver_user_id, 'user', 'message', $mid, 'New message from Admin', substr($body,0,200));
            }
        } elseif (!empty($_SESSION['user_id'])) {
            $sender_user_id = (int)$_SESSION['user_id'];
            $sender_admin_id = null;
            $receiver_admin_id = $to_admin_id ?: null;
            $receiver_user_id = $to_user_id ?: null;
            $mid = Message::send(null, $sender_user_id, $receiver_admin_id, null, $body);

            // create notification for admin
            if ($receiver_admin_id) {
                Notification::create($sender_user_id, $receiver_admin_id, 'admin', 'message', $mid, 'New message from User', substr($body,0,200));
            }
        } else {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Not authenticated']);
            exit;
        }

        echo json_encode(['success' => true, 'message_id' => $mid]);
    }

    public function inbox() {
        if (!empty($_SESSION['admin_id'])) {
            $convs = Message::getConversationsForAdmin((int)$_SESSION['admin_id']);
            require __DIR__ . '/../views/messages/inbox.php';
        } elseif (!empty($_SESSION['user_id'])) {
            $convs = Message::getConversationsForUser((int)$_SESSION['user_id']);
            require __DIR__ . '/../views/messages/inbox.php';
        } else {
            header('Location: ?page=login');
        }
    }

    public function viewConversation() {
        $admin_id = isset($_GET['admin_id']) ? (int)$_GET['admin_id'] : null;
        $user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;
        if (!$admin_id || !$user_id) {
            echo "Invalid conversation";
            exit;
        }
        $messages = Message::getConversation($admin_id, $user_id);
        // mark as read for receiver (if current user is admin or user)
        if (!empty($_SESSION['admin_id']) && $_SESSION['admin_id'] === $admin_id) {
            Message::markAsReadForReceiver($admin_id, $user_id);
        }
        require __DIR__ . '/../views/messages/conversation.php';
    }
}
