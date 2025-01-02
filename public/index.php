<!--
Path: public/index.php

-->

<?php
echo "Iniciando<br>"; // Verifica que el archivo se está ejecutando

require_once __DIR__ . '/../vendor/autoload.php';
echo "Autoload cargado<br>";

require_once __DIR__ . '/../app/controllers/URLController.php';
echo "Controlador incluido<br>";

$controller = new URLController();
echo "Instancia de URLController creada<br>";

$urls = [];
$message = '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
        echo "Método POST recibido con URL: " . htmlspecialchars($_POST['url']) . "<br>";
        $controller->saveURL($_POST['url']);
        $message = "<p style='color:green;'>URL guardada exitosamente</p>";
    }
    $urls = $controller->getAllURLs();
    echo "URLs recuperadas: <pre>" . print_r($urls, true) . "</pre>";
} catch (Exception $e) {
    echo "Excepción capturada: " . htmlspecialchars($e->getMessage()) . "<br>";
    $message = "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

require_once __DIR__ . '/../app/views/index.php';
