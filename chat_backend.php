<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$dataDir = __DIR__ . '/chat_data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

$action = $_GET['action'] ?? '';

// ---- SEND MESSAGE ----
if ($action === 'send') {
    $body = json_decode(file_get_contents('php://input'), true);
    $sessionId = preg_replace('/[^a-zA-Z0-9_-]/', '', $body['session_id'] ?? '');
    $sender    = htmlspecialchars($body['sender'] ?? 'Unknown', ENT_QUOTES);
    $role      = in_array($body['role'], ['user','agent']) ? $body['role'] : 'user';
    $text      = htmlspecialchars($body['text'] ?? '', ENT_QUOTES);

    if (!$sessionId || !$text) {
        echo json_encode(['ok' => false, 'error' => 'Missing fields']);
        exit;
    }

    $file = "$dataDir/$sessionId.json";
    $data = file_exists($file) ? json_decode(file_get_contents($file), true) : ['messages' => [], 'meta' => []];

    $msg = [
        'id'     => uniqid(),
        'role'   => $role,
        'sender' => $sender,
        'text'   => $text,
        'time'   => date('H:i'),
        'ts'     => time()
    ];

    $data['messages'][] = $msg;
    file_put_contents($file, json_encode($data));
    echo json_encode(['ok' => true, 'msg' => $msg]);
    exit;
}

// ---- POLL MESSAGES (long poll) ----
if ($action === 'poll') {
    $sessionId = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['session_id'] ?? '');
    $since     = intval($_GET['since'] ?? 0);

    if (!$sessionId) {
        echo json_encode(['ok' => false]);
        exit;
    }

    $file = "$dataDir/$sessionId.json";
    $deadline = time() + 20; // wait up to 20s for new messages

    while (time() < $deadline) {
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            $new = array_values(array_filter($data['messages'] ?? [], fn($m) => $m['ts'] > $since));
            if (count($new) > 0) {
                echo json_encode(['ok' => true, 'messages' => $new]);
                exit;
            }
        }
        usleep(700000); // check every 0.7s
    }

    echo json_encode(['ok' => true, 'messages' => []]);
    exit;
}

// ---- LIST SESSIONS (admin) ----
if ($action === 'sessions') {
    $sessions = [];
    foreach (glob("$dataDir/*.json") as $file) {
        $data = json_decode(file_get_contents($file), true);
        $msgs = $data['messages'] ?? [];
        $sessions[] = [
            'session_id' => basename($file, '.json'),
            'name'       => $data['meta']['name'] ?? 'Unknown',
            'email'      => $data['meta']['email'] ?? '',
            'started'    => $data['meta']['started'] ?? '',
            'msg_count'  => count($msgs),
            'last_msg'   => end($msgs)['text'] ?? '',
            'last_ts'    => end($msgs)['ts'] ?? 0,
            'messages'   => $msgs
        ];
    }
    usort($sessions, fn($a, $b) => $b['last_ts'] - $a['last_ts']);
    echo json_encode(['ok' => true, 'sessions' => $sessions]);
    exit;
}

// ---- SAVE META (name/email on session start) ----
if ($action === 'meta') {
    $body = json_decode(file_get_contents('php://input'), true);
    $sessionId = preg_replace('/[^a-zA-Z0-9_-]/', '', $body['session_id'] ?? '');
    if (!$sessionId) { echo json_encode(['ok'=>false]); exit; }

    $file = "$dataDir/$sessionId.json";
    $data = file_exists($file) ? json_decode(file_get_contents($file), true) : ['messages'=>[], 'meta'=>[]];
    $data['meta'] = [
        'name'    => htmlspecialchars($body['name'] ?? '', ENT_QUOTES),
        'email'   => htmlspecialchars($body['email'] ?? '', ENT_QUOTES),
        'started' => date('Y-m-d H:i:s')
    ];
    file_put_contents($file, json_encode($data));
    echo json_encode(['ok' => true]);
    exit;
}

// ---- DELETE SESSION (admin) ----
if ($action === 'delete') {
    $sessionId = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['session_id'] ?? '');
    $file = "$dataDir/$sessionId.json";
    if (file_exists($file)) unlink($file);
    echo json_encode(['ok' => true]);
    exit;
}

echo json_encode(['ok' => false, 'error' => 'Unknown action']);
?>
