<?php
require_once __DIR__ . '/../helpers/debug_helper.php';
require_once __DIR__ . '/../controllers/URLController.php';

debug_trace("Cargando la vista principal");

$controller = new URLController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
    try {
        debug_trace("Procesando formulario: Guardar URL");
        $controller->saveURL($_POST['url']);
        $message = "<div class='alert alert-success'>URL guardada exitosamente.</div>";
    } catch (Exception $e) {
        $message = "<div class='alert alert-danger'>Error al guardar la URL: " . htmlspecialchars($e->getMessage()) . "</div>";
        debug_trace("Error al guardar la URL: " . $e->getMessage());
    }
}

$urls = [];
try {
    debug_trace("Recuperando todas las URLs");
    $urls = $controller->getAllURLs();
} catch (Exception $e) {
    $message = "<div class='alert alert-danger'>Error al recuperar las URLs: " . htmlspecialchars($e->getMessage()) . "</div>";
    debug_trace("Error al recuperar las URLs: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de URLs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-YbRj5iw1shLFhA9gCmvr7cZn6a1t+9k2eA0bBIQ1eB8ZtnAdf1IZy1Ys9RVI4oJo" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-t1C7AlhC79SX8fE6IXC2CtF00JNs3fGFeRJMeJEbgUbnFQouOH29bT30f65beQYI" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Registro de URLs</h1>
        <?= $message ?>
        <form action="" method="POST" class="mb-4">
            <div class="mb-3">
                <label for="url" class="form-label">URL:</label>
                <input type="text" name="url" id="url" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
        <hr>
        <h2 class="text-center">URLs registradas</h2>
        <ul class="list-group">
            <?php foreach ($urls as $url): ?>
                <li class="list-group-item"><?= htmlspecialchars($url['url']) ?> - <small><?= $url['fecha_registro'] ?></small></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-VoPF6IL7AqV4ZpOhsA1xdyl2WyU4Gi5HV79A8eAhQFAfuKnDkrB/A59WgCW4X5wo" crossorigin="anonymous"></script>
</body>
</html>
