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

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$id = $input['id'] ?: uniqid();
$name = trim($input['name'] ?? '');
$category = trim($input['category'] ?? '');
$quantity = $input['quantity'] ?? '';
$price = $input['price'] ?? '';
$supplier = trim($input['supplier'] ?? '');
$min_threshold = (int)($input['min_threshold'] ?? 10);

// Validation
if (empty($name) || empty($category) || empty($supplier) || $quantity === '' || $price === '') {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

if (!is_numeric($quantity) || !is_numeric($price)) {
    http_response_code(400);
    echo json_encode(['error' => 'Quantity and Price must be numbers']);
    exit;
}

$quantity = (int)$quantity;
$price = (float)$price;

// Default empty sales data for new products
$sales_history = json_encode([0, 0, 0, 0]);
$monthly_sales = json_encode([0, 0, 0, 0, 0, 0]);

$stmt = $conn->prepare("INSERT INTO inventory (id, name, category, quantity, price, supplier, min_threshold, sales_history, monthly_sales) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssidsiss", $id, $name, $category, $quantity, $price, $supplier, $min_threshold, $sales_history, $monthly_sales);

if ($stmt->execute()) {
    echo json_encode([
        'id' => $id,
        'name' => $name,
        'category' => $category,
        'quantity' => $quantity,
        'price' => $price,
        'supplier' => $supplier
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $conn->error]);
}
?>