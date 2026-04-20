<?php
header('Content-Type: application/json');
require_once '../../config.php';

$id = $_GET['id'] ?? '';
$csrf_token = $_GET['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');

// CSRF Verification
if (!verify_csrf_token($csrf_token)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
    exit;
}

if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID required']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
$stmt->bind_param("s", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>