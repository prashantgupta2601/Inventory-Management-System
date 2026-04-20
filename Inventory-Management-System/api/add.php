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

$id = uniqid();
$name = $input['name'] ?? '';
$category = $input['category'] ?? '';
$quantity = (int)($input['quantity'] ?? 0);
$price = (float)($input['price'] ?? 0);
$supplier = $input['supplier'] ?? '';
$min_threshold = (int)($input['min_threshold'] ?? 10);
$sales_history = json_encode([]);
$monthly_sales = json_encode([]);

$stmt = $conn->prepare("INSERT INTO inventory (id, name, category, quantity, price, supplier, min_threshold, sales_history, monthly_sales) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssisdiss", $id, $name, $category, $quantity, $price, $supplier, $min_threshold, $sales_history, $monthly_sales);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $id, 'name' => $name]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>