<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../pas-connect/config/db.php';

try {
    $pdo = getPDO();

    // Helper: ensure column exists (add non-destructive)
    $ensureColumn = function($col, $def) use ($pdo) {
        $stmt = $pdo->prepare("SHOW COLUMNS FROM users LIKE :col");
        $stmt->execute(['col' => $col]);
        if (!$stmt->fetch()) {
            $pdo->exec("ALTER TABLE users ADD COLUMN {$col} {$def}");
        }
    };

    // Ensure commonly used columns exist (phone, avatar_url, pas_member_id, last_login)
    $ensureColumn('phone', "VARCHAR(50) DEFAULT NULL");
    $ensureColumn('avatar_url', "VARCHAR(255) DEFAULT NULL");
    $ensureColumn('pas_member_id', "VARCHAR(100) DEFAULT NULL");
    $ensureColumn('last_login', "DATETIME DEFAULT NULL");

    // Determine optional id from URL: /tables/users or /tables/users/{id}
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = array_values(array_filter(explode('/', $path)));
    // Find where "tables" and "users" occur
    $id = null;
    for ($i = 0; $i < count($segments); $i++) {
        if ($segments[$i] === 'tables' && isset($segments[$i+1]) && $segments[$i+1] === 'users') {
            if (isset($segments[$i+2])) {
                $id = $segments[$i+2];
            }
            break;
        }
    }

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        // listing or fetch single
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;
        if ($id) {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && !isset($row['password_hash']) && isset($row['password'])) $row['password_hash'] = $row['password'];
            echo json_encode(['data' => $row ? [$row] : [], 'total' => $row ? 1 : 0]);
            exit;
        }

        $stmt = $pdo->prepare('SELECT * FROM users ORDER BY id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Add password_hash alias for compatibility with existing front-end
        $rows = array_map(function($r){
            if (!isset($r['password_hash']) && isset($r['password'])) $r['password_hash'] = $r['password'];
            return $r;
        }, $rows);
        echo json_encode(['data' => $rows, 'total' => count($rows)]);
        exit;
    }

    if ($method === 'POST') {
        // Accept JSON or form fields
        $raw = file_get_contents('php://input');
        $input = null;
        if ($raw) {
            $json = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE) $input = $json;
        }
        if ($input === null) $input = $_POST;

        // For form-data file uploads (avatar), check $_FILES
        if (!empty($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/avatars';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $f = $_FILES['photo'];
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','gif'];
            if (!in_array($ext, $allowed)) {
                echo json_encode(['success' => false, 'message' => 'Format gambar tidak disokong']);
                exit;
            }
            $filename = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            $target = $uploadDir . '/' . $filename;
            if (move_uploaded_file($f['tmp_name'], $target)) {
                $input['avatar_url'] = 'public/uploads/avatars/' . $filename;
            }
        }

        // Required fields
        $email = trim($input['email'] ?? '');
        $password = trim($input['password_hash'] ?? $input['password'] ?? '');
        $name = trim($input['full_name'] ?? $input['name'] ?? '');
        $phone = trim($input['phone'] ?? '');
        $pas_member_id = trim($input['pas_member_id'] ?? $input['pasMemberId'] ?? '');
        $avatar_url = $input['avatar_url'] ?? null;

        if (!$email || !$password) {
            echo json_encode(['success' => false, 'message' => 'Email dan kata laluan diperlukan']);
            exit;
        }

        // basic email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Format email tidak sah']);
            exit;
        }

        // Check existing
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Emel sudah didaftarkan']);
            exit;
        }

        // Insert
        $insert = $pdo->prepare('INSERT INTO users (email, password, name, phone, pas_member_id, avatar_url, created_at) VALUES (:email, :password, :name, :phone, :pas_member_id, :avatar_url, NOW())');
        $insert->execute([
            'email' => $email,
            'password' => $password,
            'name' => $name ?: null,
            'phone' => $phone ?: null,
            'pas_member_id' => $pas_member_id ?: null,
            'avatar_url' => $avatar_url ?: null
        ]);

        $id = $pdo->lastInsertId();
        $stmt = $pdo->prepare('SELECT id, email, name, phone, pas_member_id, avatar_url, created_at FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($user);
        exit;
    }

    if ($method === 'PATCH' || $method === 'PUT') {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID diperlukan untuk kemaskini']);
            exit;
        }

        // Read JSON body
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['success' => false, 'message' => 'Bad JSON']);
            exit;
        }

        // Allowed columns to update
        $allowed = ['email','name','phone','avatar_url','pas_member_id','last_login','is_active','password','password_hash'];
        $updates = [];
        $params = ['id' => $id];
        foreach ($data as $k => $v) {
            if (in_array($k, $allowed)) {
                // Map password_hash -> password
                if ($k === 'password_hash') {
                    $updates[] = 'password = :password';
                    $params['password'] = $v;
                } else {
                    $updates[] = "{$k} = :{$k}";
                    $params[$k] = $v;
                }
            }
        }

        if (count($updates) === 0) {
            echo json_encode(['success' => false, 'message' => 'Tiada medan dibenarkan untuk dikemaskini']);
            exit;
        }

        $sql = 'UPDATE users SET ' . implode(', ', $updates) . ' WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $stmt = $pdo->prepare('SELECT id, email, name, phone, pas_member_id, avatar_url, last_login, is_active FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'user' => $user]);
        exit;
    }

    if ($method === 'DELETE') {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID required']);
            exit;
        }
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        echo json_encode(['success' => true]);
        exit;
    }

    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
    exit;
}
