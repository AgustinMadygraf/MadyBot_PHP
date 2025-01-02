<!--
Path: app/helpers/debug_helper.php
Este archivo contiene una función para depurar la aplicación. 
-->

<?php
function debug_trace($message) {
    $trace = debug_backtrace();
    $caller = $trace[0];
    echo "<p style='color:blue;'><strong>Debug:</strong> $message<br>";
    echo "Archivo: " . $caller['file'] . "<br>";
    echo "Línea: " . $caller['line'] . "</p>";
}
