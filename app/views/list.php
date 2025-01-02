<!--
Path: app/views/list.php

-->

<?php
require_once __DIR__ . '/../bootstrap.php';

debug_trace("Cargando la vista de listado");

// Inicializar el controlador mediante Bootstrap
$controller = Bootstrap::initialize();
$urls = [];

try {
    debug_trace("Recuperando todas las URLs para la vista de listado");
    $urls = $controller->getAllURLs();
} catch (Exception $e) {
    debug_trace("Error al recuperar las URLs: " . $e->getMessage());
    echo "<p>Error al recuperar las URLs: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
<?php if (!empty($urls)): ?>
    <h2>URLs almacenadas</h2>
    <ul>
        <?php foreach ($urls as $url): ?>
            <li><strong>ID:</strong> <?= $url['id'] ?> | <strong>URL:</strong> <?= $url['url'] ?> | <strong>Fecha:</strong> <?= $url['fecha_registro'] ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay URLs almacenadas aún.</p>
<?php endif; ?>
