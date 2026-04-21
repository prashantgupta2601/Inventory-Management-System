<?php
require_once '../config.php';
header('Content-Type: application/json');

// Auth check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden: Admin access required']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input or missing ID']);
    exit;
}

$id = $input['id'];
$name = $input['name'] ?? '';
$category = $input['category'] ?? '';
$quantity = (int)($input['quantity'] ?? 0);
$price = (float)($input['price'] ?? 0);
$supplier = $input['supplier'] ?? '';

$stmt = $conn->prepare("UPDATE inventory SET name=?, category=?, quantity=?, price=?, supplier=? WHERE id=?");
$stmt->bind_param("ssidss", $name, $category, $quantity, $price, $supplier, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $conn->error]);
}
?>