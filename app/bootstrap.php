<!--
Path: app/bootstrap.php

-->

<?php

require_once __DIR__ . '/helpers/debug_helper.php';
require_once __DIR__ . '/models/URLModel.php';
require_once __DIR__ . '/controllers/URLController.php';

class Bootstrap {
    public static function initialize() {
        debug_trace("Inicializando dependencias");
        $model = new URLModel();
        debug_trace("Modelo URLModel instanciado");
        $controller = new URLController($model);
        debug_trace("Controlador URLController instanciado con dependencias inyectadas");
        return $controller;
    }
}
