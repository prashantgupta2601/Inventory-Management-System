<?php
header('Content-Type: application/json');
require_once '../../config.php';

$input = json_decode(file_get_contents('php://input'), true);

// CSRF Verification
$csrf_token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($input['csrf_token'] ?? '');
if (!verify_csrf_token($csrf_token)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
    exit;
}

$id       = $input['id'] ?? '';
$name     = $input['name'] ?? '';
$category = $input['category'] ?? '';
$quantity = (int)($input['quantity'] ?? 0);
$price    = (float)($input['price'] ?? 0);
$supplier = $input['supplier'] ?? '';

if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID required']);
    exit;
}

$stmt = $conn->prepare("UPDATE inventory SET name = ?, category = ?, quantity = ?, price = ?, supplier = ? WHERE id = ?");
$stmt->bind_param("ssidss", $name, $category, $quantity, $price, $supplier, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>