<!--
Path: public/index.php

-->

<?php
// Función de depuración
function debug_trace($message) {
    $trace = debug_backtrace();
    $caller = $trace[0];
    echo "<p style='color:blue;'><strong>Debug:</strong> $message<br>";
    echo "Archivo: " . $caller['file'] . "<br>";
    echo "Línea: " . $caller['line'] . "</p>";
}

debug_trace("Iniciando la ejecución");

require_once __DIR__ . '/../vendor/autoload.php';
debug_trace("Autoload cargado");

require_once __DIR__ . '/../app/controllers/URLController.php';
debug_trace("Controlador incluido");

$controller = new URLController();
debug_trace("Instancia de URLController creada");

$urls = [];
$message = '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
        debug_trace("Método POST recibido con URL: " . htmlspecialchars($_POST['url']));
        $controller->saveURL($_POST['url']);
        $message = "<p style='color:green;'>URL guardada exitosamente</p>";
    }
    $urls = $controller->getAllURLs();
    debug_trace("URLs recuperadas: " . json_encode($urls)); // Usamos json_encode para facilitar la visualización
} catch (Exception $e) {
    debug_trace("Excepción capturada: " . htmlspecialchars($e->getMessage()));
    $message = "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

require_once __DIR__ . '/../app/views/index.php';
