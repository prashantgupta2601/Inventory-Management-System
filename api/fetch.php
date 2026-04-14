<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('../data.json'), true);
echo json_encode($data['inventory']);
?>