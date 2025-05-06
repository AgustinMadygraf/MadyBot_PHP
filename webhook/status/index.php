<?php
/* Path: c:\AppServ\www\coopebot_PHP\webhook\status\index.php */

// Configuración inicial
header('Content-Type: application/json');

// Verificar si el sistema está operativo
$status = [
    'status' => 'ok',
    'timestamp' => date('Y-m-d H:i:s'),
    'webhook_logs' => []
];

// Leer los últimos logs de webhooks (si existen)
$logFile = __DIR__ . '/../logs/webhook.log';
if (file_exists($logFile)) {
    $logs = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $status['webhook_logs'] = array_slice($logs, -5); // Últimos 5 registros
} else {
    $status['webhook_logs'] = 'No hay registros disponibles.';
}

// Responder con el estado
echo json_encode($status);