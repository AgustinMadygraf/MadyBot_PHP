<!--
Path: app/views/index.php

-->

<?php
require_once __DIR__ . '/../helpers/debug_helper.php';
debug_trace("Cargando la vista principal");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de URLs</title>
</head>
<body>
    <h1>Registro de URLs</h1>
    <?php
    debug_trace("Mostrando mensaje actual");
    echo "Mensaje actual: " . $message . "<br>";
    ?>
    <form action="/index.php" method="POST">
        <label for="url">URL:</label>
        <input type="text" name="url" id="url" required />
        <button type="submit">Guardar</button>
    </form>
    <hr>
    <?php
    debug_trace("Incluyendo lista de URLs");
    require_once 'list.php';
    ?>
</body>
</html>
