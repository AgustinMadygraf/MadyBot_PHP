<?php
/* path: webhook/index.php */

// Declarar el modo estricto de PHP
declare(strict_types=1);

// Archivo: webhook/index.php
// Propósito: Manejar eventos entrantes desde servicios externos.

// Incluir archivo de configuración
require_once __DIR__ . '/../config.php';

// Incluir la clase Logger
use App\Lib\Logger;
use App\Services\WebhookValidator;

// Inicializar el logger
$logger = Logger::getInstance();

// Inicializar el validador
$validator = new WebhookValidator();

// Registrar detalles del webhook
$logger->info(sprintf('Solicitud entrante desde IP: %s', $_SERVER['REMOTE_ADDR']));

// Validar método HTTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer el cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $payload = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $logger->error('El payload no es un JSON válido.');
        http_response_code(400);
        echo 'El payload no es un JSON válido.';
        exit;
    }

    // Validar el payload
    if (!$validator->validate($payload)) {
        $errors = $validator->getErrors();
        $logger->error('Errores de validación: ' . implode(', ', $errors));
        http_response_code(400);
        echo 'Errores de validación: ' . implode(', ', $errors);
        exit;
    }

    $logger->info('Payload validado correctamente.');

    // Procesar el contenido del webhook
    // ... lógica personalizada ...

    $logger->info('Webhook procesado correctamente');
    echo 'Webhook procesado correctamente';
} else {
    $logger->warning(sprintf('Método no permitido: %s', $_SERVER['REQUEST_METHOD']));
    http_response_code(405);
    echo 'Método no permitido';
}