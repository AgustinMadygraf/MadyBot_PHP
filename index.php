<?php
/* Path: index.php  */

// Declarar el modo estricto de PHP
declare(strict_types=1);

// Archivo: index.php
// Propósito: Página principal con opciones de navegación.

// Incluir la clase Logger
require_once __DIR__ . '/lib/Logger.php';
use App\Lib\Logger;
use Http\StatusCode;

// Inicializar el logger
$logger = Logger::getInstance();

// Set log level based on environment
$environment = getenv('APP_ENV') ?: 'production';
if ($environment === 'development') {
    $logger->setLogLevel('debug');
} else {
    $logger->setLogLevel('info');
}

$logger->info('Página principal cargada.');

// Log incoming request
global $logger;
$logger->info(sprintf('Solicitud entrante: Método=%s, IP=%s', $_SERVER['REQUEST_METHOD'], $_SERVER['REMOTE_ADDR']));

// Validate HTTP method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $logger->warning(sprintf('Método no permitido: %s desde IP: %s', $_SERVER['REQUEST_METHOD'], $_SERVER['REMOTE_ADDR']));
    header('Allow: POST');
    http_response_code(405); // Method Not Allowed
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido. Solo se permite POST.'
    ]);
    exit;
}

// Simulate a scenario to demonstrate HTTP status code usage
try {
    // Example: Simulate a successful operation
    http_response_code(StatusCode::getCode('success'));

    // Log successful operation
    $logger->info('Operación completada exitosamente. Detalles: Página principal cargada correctamente.');
} catch (Exception $e) {
    // Log the error and send an appropriate HTTP status code
    $logger->error('Error en la página principal: ' . $e->getMessage());
    http_response_code(StatusCode::getCode('internal_server_error'));
    echo json_encode([
        'status' => 'error',
        'message' => 'Ocurrió un error interno.'
    ]);
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Bienvenido!!!</h1>
    <p>Seleccione una de las siguientes opciones:</p>

    <a href="forwarding/index.php" class="button">Forwarding</a>
    <p>El módulo de Forwarding permite redirigir solicitudes a otros servicios o URLs.</p>

    <a href="webhook/index.php" class="button">Webhook</a>
    <p>El módulo de Webhook permite manejar eventos entrantes desde servicios externos.</p>
</body>
</html>