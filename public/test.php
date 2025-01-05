<?php

    $dbhost = 'localhost';
    $dbuser = 'l0013193_tienda';
    $dbpass = '12ZOsuwode';
    $dbname = 'l0013193_tienda';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);

    if (!$conn) {
        die('Error al conectarse al servidor MySQL: ' . mysqli_connect_error());
    }

    if (!mysqli_select_db($conn, $dbname)) {
        die('Error al seleccionar la base de datos: ' . mysqli_error($conn));
    }

    echo 'Conexión exitosa a la base de datos';
?>