<?php
header('Content-Type: application/json');
function calculateAIInsights($sales_history) {
    if (empty($sales_history)) return ['forecast' => 0, 'trend' => 'stable'];
    
    $forecast = round(array_sum($sales_history) / count($sales_history), 2);
    
    $first = $sales_history[0];
    $last = end($sales_history);
    $trend = ($last > $first) ? 'up' : (($last < $first) ? 'down' : 'stable');
    
    return [
        'forecast' => $forecast,
        'trend' => $trend
    ];
}

$data = json_decode(file_get_contents('../data.json'), true);
$inventory = $data['inventory'];

// Add forecast and trend to each item
foreach ($inventory as &$item) {
    $insights = isset($item['sales_history']) ? calculateAIInsights($item['sales_history']) : ['forecast' => 0, 'trend' => 'stable'];
    $item['forecast'] = $insights['forecast'];
    $item['trend'] = $insights['trend'];
}

echo json_encode($inventory);
?>