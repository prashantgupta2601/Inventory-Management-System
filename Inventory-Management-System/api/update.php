<?php
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$data = json_decode(file_get_contents('../data.json'), true);
foreach ($data['inventory'] as &$item) {
    if ($item['id'] === $input['id']) {
        $item = array_merge($item, $input);
        $item['last_updated'] = date('Y-m-d H:i:s');
        break;
    }
}
file_put_contents('../data.json', json_encode($data, JSON_PRETTY_PRINT));
echo json_encode(['success' => true]);
?>