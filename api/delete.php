<?php
header('Content-Type: application/json');
$id = $_GET['id'];

$data = json_decode(file_get_contents('../data.json'), true);
$data['inventory'] = array_filter($data['inventory'], function($item) use ($id) {
    return $item['id'] !== $id;
});
file_put_contents('../data.json', json_encode($data, JSON_PRETTY_PRINT));
echo json_encode(['success' => true]);
?>