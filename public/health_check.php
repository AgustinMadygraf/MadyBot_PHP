<?php
header('Content-Type: application/json');

$response = [
    'status' => 'ok',
    'message' => 'PHP endpoint is healthy'
];

echo json_encode($response);
?>