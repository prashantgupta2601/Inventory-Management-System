<?php
require_once '../config.php';

header('Content-Type: application/json');

// Auth check
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$query = "SELECT * FROM inventory";
$result = $conn->query($query);

$inventory = [];
while ($row = $result->fetch_assoc()) {
    $quantity = (int)$row['quantity'];
    
    // AI Forecasting: Simple 20% Growth logic as requested
    $forecastVal = round($quantity * 1.2);
    
    // Trend calculation: Compare to threshold
    $trend = ($quantity < (int)$row['min_threshold']) ? 'down' : 'up';
    
    $row['sales_history'] = json_decode($row['sales_history'], true) ?? [];
    $row['monthly_sales'] = json_decode($row['monthly_sales'], true) ?? [];
    $row['forecast'] = $forecastVal;
    $row['trend'] = $trend;
    
    $inventory[] = $row;
}

echo json_encode($inventory);
?>