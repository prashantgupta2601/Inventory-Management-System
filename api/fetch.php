<?php
require_once '../config.php';
require_once 'ForecastingUtil.php';

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
    $sales_history = json_decode($row['sales_history'], true) ?? [];
    $monthly_sales = json_decode($row['monthly_sales'], true) ?? [];
    
    // Use the professional ForecastingUtil for AI insights
    $forecastVal = ForecastingUtil::predictNext($sales_history);
    $trend = ForecastingUtil::calculateTrend($sales_history);
    
    $row['sales_history'] = $sales_history;
    $row['monthly_sales'] = $monthly_sales;
    $row['forecast'] = $forecastVal;
    $row['trend'] = $trend;
    
    $inventory[] = $row;
}

echo json_encode($inventory);
?>