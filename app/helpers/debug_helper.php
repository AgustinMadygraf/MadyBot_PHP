<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

function debug_trace($message) {
    if ($_ENV['APP_ENV_PRODUCTION'] !== 'true') {
        $trace = debug_backtrace();
        $caller = $trace[0];
        echo "<p style='color:blue;'><strong>Debug:</strong> $message<br>";
        echo "Archivo: " . $caller['file'] . "<br>";
        echo "Línea: " . $caller['line'] . "</p>";
    }
}
