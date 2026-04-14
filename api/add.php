<?php
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$data = json_decode(file_get_contents('../data.json'), true);
$newItem = [
    'id' => uniqid(),
    'name' => $input['name'],
    'category' => $input['category'],
    'quantity' => (int)$input['quantity'],
    'price' => (float)$input['price'],
    'supplier' => $input['supplier'],
    'last_updated' => date('Y-m-d H:i:s')
];
$data['inventory'][] = $newItem;
file_put_contents('../data.json', json_encode($data, JSON_PRETTY_PRINT));
echo json_encode($newItem);
?>