<?php
require_once __DIR__ . '/../app/controllers/URLController.php';

$controller = new URLController();
$urls = [];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
        $controller->saveURL($_POST['url']);
        echo "<p style='color:green;'>URL guardada exitosamente</p>";
    }
    $urls = $controller->getAllURLs();
} catch (Exception $e) {
    echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
}

// Incluir la vista
require_once __DIR__ . '/../app/views/index.php';
