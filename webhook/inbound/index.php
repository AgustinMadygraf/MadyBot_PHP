<?php
/* path: webhook/inbound/index.php */

// Leer el cuerpo de la solicitud
$payload = file_get_contents('php://input');

// Decodificar el JSON recibido
$data = json_decode($payload, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Solicitud incorrecta
    echo "Payload inválido";
    exit;
}

// Procesar los datos
if (isset($data['event']) && $data['event'] === 'message_received') {
    // Guardar el mensaje en la base de datos o procesarlo
    file_put_contents('logs/inbound.log', $payload . PHP_EOL, FILE_APPEND);
    echo "Mensaje procesado";
} else {
    http_response_code(400);
    echo "Evento no reconocido";
}