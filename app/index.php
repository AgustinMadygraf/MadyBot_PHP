<!--
Path: app/index.php

-->

<?php
require_once __DIR__ . '/../app/helpers/debug_helper.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/controllers/URLController.php';
require_once __DIR__ . '/../app/models/URLModel.php';
require_once __DIR__ . '/../app/services/URLValidator.php';

debug_trace("Iniciando la ejecución");

// Crear instancias de las dependencias
$model = new URLModel();
debug_trace("Modelo URLModel instanciado");

$validator = new URLValidator();
debug_trace("Servicio URLValidator instanciado");

// Pasar las dependencias al controlador
$controller = new URLController($model, $validator);
debug_trace("Controlador URLController instanciado con dependencias");

$urls = [];
$message = '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
        debug_trace("Método POST recibido con URL: " . htmlspecialchars($_POST['url']));
        $controller->saveURL($_POST['url']);
        $message = "<p style='color:green;'>URL guardada exitosamente</p>";
    }
    $urls = $controller->getAllURLs();
    debug_trace("URLs recuperadas: " . json_encode($urls));
} catch (Exception $e) {
    debug_trace("Excepción capturada: " . htmlspecialchars($e->getMessage()));
    $message = "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

require_once __DIR__ . '/../app/views/index.php';
