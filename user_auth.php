<?php
header('Content-Type: application/json');
session_start();

$dataDir = __DIR__ . '/chat_data/';
$usersFile = $dataDir . 'users.json';

if (!is_dir($dataDir)) mkdir($dataDir, 0755, true);

function loadUsers($file) {
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

function saveUsers($file, $users) {
    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
}

function rateLimit($ip) {
    $file = sys_get_temp_dir() . '/ua_' . md5($ip) . '.json';
    $attempts = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $attempts = array_filter($attempts, function($t){ return $t > time() - 600; });
    if (count($attempts) >= 10) return false;
    $attempts[] = time();
    file_put_contents($file, json_encode(array_values($attempts)));
    return true;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];

// ---- REGISTER ----
if ($action === 'register') {
    if (!rateLimit($ip)) { echo json_encode(['ok'=>false,'error'=>'Too many attempts. Wait 10 minutes.']); exit; }

    $username = trim($_POST['username'] ?? '');
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    if (empty($username) || empty($email) || empty($password))  { echo json_encode(['ok'=>false,'error'=>'All fields are required.']); exit; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))              { echo json_encode(['ok'=>false,'error'=>'Invalid email address.']); exit; }
    if (strlen($username) < 3 || strlen($username) > 30)        { echo json_encode(['ok'=>false,'error'=>'Username must be 3-30 characters.']); exit; }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username))            { echo json_encode(['ok'=>false,'error'=>'Username can only contain letters, numbers, underscores.']); exit; }
    if (strlen($password) < 8)                                   { echo json_encode(['ok'=>false,'error'=>'Password must be at least 8 characters.']); exit; }
    if ($password !== $confirm)                                  { echo json_encode(['ok'=>false,'error'=>'Passwords do not match.']); exit; }

    $users = loadUsers($usersFile);
    foreach ($users as $u) {
        if (strtolower($u['username']) === strtolower($username)) { echo json_encode(['ok'=>false,'error'=>'Username already taken.']); exit; }
        if ($u['email'] === $email)                               { echo json_encode(['ok'=>false,'error'=>'Email already registered.']); exit; }
    }

    $users[] = [
        'id'         => uniqid('u_'),
        'username'   => $username,
        'email'      => $email,
        'password'   => password_hash($password, PASSWORD_BCRYPT),
        'created_at' => date('Y-m-d H:i:s')
    ];
    saveUsers($usersFile, $users);

    echo json_encode(['ok'=>true, 'message'=>'Account created! You can now log in.']);
    exit;
}

// ---- LOGIN ----
if ($action === 'login') {
    if (!rateLimit($ip)) { echo json_encode(['ok'=>false,'error'=>'Too many attempts. Wait 10 minutes.']); exit; }

    $identifier = trim($_POST['identifier'] ?? '');
    $password   = $_POST['password'] ?? '';

    if (empty($identifier) || empty($password)) { echo json_encode(['ok'=>false,'error'=>'All fields are required.']); exit; }

    $users = loadUsers($usersFile);
    $found = null;
    foreach ($users as $u) {
        if (strtolower($u['username']) === strtolower($identifier) || $u['email'] === strtolower($identifier)) {
            $found = $u; break;
        }
    }

    if (!$found || !password_verify($password, $found['password'])) {
        echo json_encode(['ok'=>false,'error'=>'Invalid username or password.']);
        exit;
    }

    session_regenerate_id(true);
    $_SESSION['user_id']       = $found['id'];
    $_SESSION['username']      = $found['username'];
    $_SESSION['email']         = $found['email'];
    $_SESSION['logged_in_at']  = time();

    echo json_encode(['ok'=>true, 'username'=>$found['username'], 'email'=>$found['email']]);
    exit;
}

// ---- LOGOUT ----
if ($action === 'logout') {
    session_destroy();
    echo json_encode(['ok'=>true]);
    exit;
}

// ---- CHECK SESSION ----
if ($action === 'check') {
    if (isset($_SESSION['user_id'])) {
        echo json_encode(['ok'=>true, 'logged_in'=>true, 'username'=>$_SESSION['username'], 'email'=>$_SESSION['email'], 'id'=>$_SESSION['user_id']]);
    } else {
        echo json_encode(['ok'=>true, 'logged_in'=>false]);
    }
    exit;
}

// ---- LIST USERS (admin) ----
if ($action === 'list_users') {
    $users = loadUsers($usersFile);
    // Strip passwords before sending
    $safe = array_map(function($u) {
        return ['id'=>$u['id'],'username'=>$u['username'],'email'=>$u['email'],'created_at'=>$u['created_at']];
    }, $users);
    echo json_encode(['ok'=>true, 'users'=>array_values($safe)]);
    exit;
}

// ---- DELETE USER (admin) ----
if ($action === 'delete_user') {
    $userId  = $_POST['user_id'] ?? '';
    $users   = loadUsers($usersFile);
    $users   = array_filter($users, function($u) use ($userId) { return $u['id'] !== $userId; });
    saveUsers($usersFile, array_values($users));
    echo json_encode(['ok'=>true]);
    exit;
}

echo json_encode(['ok'=>false,'error'=>'Unknown action']);
?>
