<?php
require_once '../config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Total Items
$totalResult = $conn->query("SELECT COUNT(*) as count FROM inventory");
$totalItems = $totalResult->fetch_assoc()['count'];

// Low Stock Items (quantity < min_threshold or default 10)
$lowStockResult = $conn->query("SELECT COUNT(*) as count FROM inventory WHERE quantity < min_threshold");
$lowStockItems = $lowStockResult->fetch_assoc()['count'];

// Total Inventory Value
$valueResult = $conn->query("SELECT SUM(quantity * price) as total_value FROM inventory");
$totalValue = $valueResult->fetch_assoc()['total_value'] ?? 0;

echo json_encode([
    'totalItems' => (int)$totalItems,
    'lowStockItems' => (int)$lowStockItems,
    'inventoryValue' => number_format($totalValue, 2)
]);
?>
