<?php
/* Path: webhook/index.php */

// Declarar el modo estricto de PHP
declare(strict_types=1);

// Archivo: webhook/index.php
// Propósito: Manejar eventos entrantes desde servicios externos.

// Configurar cabeceras HTTP para respuestas JSON
header('Content-Type: application/json');

// Incluir dependencias necesarias
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/autoload.php';

// Incluir la clase Logger
use App\Lib\Logger;
use App\Services\WebhookValidator;
use App\Http\ApiResponse;

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
        echo ApiResponse::error('El payload no es un JSON válido.', 400);
        exit;
    }

    // Validar el payload
    if (!$validator->validate($payload)) {
        $errors = $validator->getErrors();
        $logger->error('Errores de validación: ' . implode(', ', $errors));
        echo ApiResponse::error('Errores de validación.', 400, $errors);
        exit;
    }

    $logger->info('Payload validado correctamente.');

    // Procesar el contenido del webhook
    // ... lógica personalizada ...

    $logger->info('Webhook procesado correctamente');
    echo ApiResponse::success(null, 'Webhook procesado correctamente');
} else {
    // Enviar encabezado Allow para métodos no permitidos
    header('Allow: POST');
    $logger->warning(sprintf('Método no permitido: %s', $_SERVER['REQUEST_METHOD']));
    echo ApiResponse::error('Método no permitido', 405);
    exit;
}