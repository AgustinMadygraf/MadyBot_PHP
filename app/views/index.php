<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de URLs</title>
</head>
<body>
    <h1>Registro de URLs</h1>
    <form action="/index.php" method="POST">
        <label for="url">URL:</label>
        <input type="text" name="url" id="url" required />
        <button type="submit">Guardar</button>
    </form>
    <hr>
    <?php require_once 'list.php'; ?>
</body>
</html>
