<?php
require_once '../config.php';
header('Content-Type: application/json');

// Auth check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden: Admin access required']);
    exit;
}

$id = $_GET['id'] ?? '';

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing product ID']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
$stmt->bind_param("s", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product deleted successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $conn->error]);
}
?>