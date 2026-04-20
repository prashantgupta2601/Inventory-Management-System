<?php
require_once '../../config.php';
require_once 'ForecastingUtil.php';

// Auth check
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Set headers for download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=inventory_report_' . date('Y-m-d') . '.csv');

// Create file pointer
$output = fopen('php://output', 'w');

// Set CSV headers
fputcsv($output, [
    'Item ID', 
    'Name', 
    'Category', 
    'Quantity', 
    'Price ($)', 
    'Supplier', 
    'Min Threshold', 
    'Predicted Demand', 
    'Trend %', 
    'Confidence %',
    'Last Updated'
]);

// Fetch data
$stmt = $conn->prepare("SELECT * FROM inventory ORDER BY name ASC");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $sales_history = json_decode($row['sales_history'] ?? '[]', true);
    $monthly_sales = json_decode($row['monthly_sales'] ?? '[]', true);
    
    // Calculate current AI insights for the report
    $data = !empty($monthly_sales) ? $monthly_sales : $sales_history;
    $insights = ForecastingUtil::holtLinearForecast($data);
    
    fputcsv($output, [
        $row['id'],
        $row['name'],
        $row['category'],
        $row['quantity'],
        number_format($row['price'], 2),
        $row['supplier'],
        $row['min_threshold'],
        $insights['forecast'],
        $insights['trend_percentage'] . '%',
        $insights['confidence'] . '%',
        $row['last_updated']
    ]);
}

fclose($output);
exit;
