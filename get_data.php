<!--
Path: get_data.php
Este archivo PHP se encarga de obtener un endpoint y devolverlo en formato JSON.
-->

<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

try {
    $endpoint = 'http://192.168.0.118:5000';

    // Validar si el endpoint es válido
    if (empty($endpoint) || !filter_var($endpoint, FILTER_VALIDATE_URL)) {
        throw new Exception('El endpoint es inválido o está vacío');
    }

    $data = [
        'endpoint' => $endpoint,
        'timestamp' => date('Y-m-d H:i:s')
    ];

    echo json_encode($data);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error al obtener endpoint',
        'message' => $e->getMessage()
    ]);
}
