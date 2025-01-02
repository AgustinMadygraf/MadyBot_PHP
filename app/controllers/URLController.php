<!--
Path: app/controllers/URLController.php

-->

<?php
require_once __DIR__ . '/../models/URLModel.php';
require_once __DIR__ . '/../helpers/debug_helper.php'; // Incluir el helper de depuración

class URLController {
    private $model;

    public function __construct() {
        debug_trace("Inicializando el controlador URLController");
        $this->model = new URLModel();
        debug_trace("Modelo URLModel instanciado");
    }

    public function saveURL($url) {
        debug_trace("Intentando guardar la URL: " . htmlspecialchars($url));
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            debug_trace("URL válida");
            return $this->model->saveURL($url);
        } else {
            debug_trace("URL inválida: " . htmlspecialchars($url));
            throw new Exception("La URL ingresada no es válida");
        }
    }

    public function getAllURLs() {
        debug_trace("Recuperando todas las URLs");
        $urls = $this->model->getAllURLs();
        debug_trace("URLs recuperadas: " . json_encode($urls));
        return $urls;
    }
}
