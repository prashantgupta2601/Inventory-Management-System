<?php
header('Content-Type: application/json');
function calculateForecast($sales_history) {
    if (empty($sales_history)) return 0;
    return round(array_sum($sales_history) / count($sales_history), 2);
}

$data = json_decode(file_get_contents('../data.json'), true);
$inventory = $data['inventory'];

// Add forecast to each item
foreach ($inventory as &$item) {
    $item['forecast'] = isset($item['sales_history']) ? calculateForecast($item['sales_history']) : 0;
}

echo json_encode($inventory);
?>