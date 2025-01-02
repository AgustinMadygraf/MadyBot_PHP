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
