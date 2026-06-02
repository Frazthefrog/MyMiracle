<?php
header('Content-Type: application/json');
$file = __DIR__ . '/chat_data/bookings.json';
$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'clear') {
    file_put_contents($file, json_encode([]));
    echo json_encode(['ok' => true]);
    exit;
}

if ($action === 'save_booking') {
    $booking = [
        'fname'    => htmlspecialchars($_POST['fname']   ?? '', ENT_COMPAT),
        'lname'    => htmlspecialchars($_POST['lname']   ?? '', ENT_COMPAT),
        'email'    => htmlspecialchars($_POST['email']   ?? '', ENT_COMPAT),
        'company'  => htmlspecialchars($_POST['company'] ?? '', ENT_COMPAT),
        'service'  => htmlspecialchars($_POST['service'] ?? '', ENT_COMPAT),
        'urgency'  => htmlspecialchars($_POST['urgency'] ?? '', ENT_COMPAT),
        'message'  => htmlspecialchars($_POST['message'] ?? '', ENT_COMPAT),
        'username' => htmlspecialchars($_POST['username'] ?? '', ENT_COMPAT),
        'date'     => date('Y-m-d H:i:s'),
        'files'    => []
    ];
    $bookings = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $bookings[] = $booking;
    file_put_contents($file, json_encode($bookings));
    echo json_encode(['ok' => true]);
    exit;
}

// Default: get all bookings
$bookings = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
echo json_encode(['ok' => true, 'bookings' => $bookings]);
?>
