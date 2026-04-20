<?php
header('Content-Type: application/json');
require_once __DIR__ . '/ForecastingUtil.php';

function calculateAIInsights($sales_history, $monthly_sales = []) {
    // Prefer monthly_sales (last 6 months) for better trend detection
    $data = !empty($monthly_sales) ? $monthly_sales : $sales_history;
    
    if (empty($data)) {
        return [
            'forecast' => 0, 
            'trend' => 'stable', 
            'trend_percentage' => 0,
            'confidence' => 0
        ];
    }
    
    $insights = ForecastingUtil::holtLinearForecast($data);
    
    $trend = ($insights['trend_percentage'] > 0.5) ? 'up' : (($insights['trend_percentage'] < -0.5) ? 'down' : 'stable');
    
    return [
        'forecast' => $insights['forecast'],
        'trend' => $trend,
        'trend_percentage' => $insights['trend_percentage'],
        'confidence' => $insights['confidence']
    ];
}

require_once '../../config.php';

$inventory = [];
$sql = "SELECT * FROM inventory ORDER BY name ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($item = $result->fetch_assoc()) {
        $item['sales_history'] = json_decode($item['sales_history'] ?? '[]', true);
        $item['monthly_sales'] = json_decode($item['monthly_sales'] ?? '[]', true);
        
        $insights = calculateAIInsights($item['sales_history'], $item['monthly_sales']);
        $item['forecast'] = $insights['forecast'];
        $item['trend'] = $insights['trend'];
        $item['trend_percentage'] = $insights['trend_percentage'];
        $item['confidence'] = $insights['confidence'];
        
        $inventory[] = $item;
    }
}

echo json_encode($inventory);
?>