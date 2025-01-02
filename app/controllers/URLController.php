<!--
Path: app/controllers/URLController.php

-->

<?php
require_once __DIR__ . '/../models/URLModel.php';

class URLController {
    private $model;

    public function __construct() {
        echo "Inicializando el controlador URLController<br>";
        $this->model = new URLModel();
        echo "Modelo URLModel instanciado<br>";
    }

    public function saveURL($url) {
        echo "Intentando guardar la URL: " . htmlspecialchars($url) . "<br>";
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            echo "URL válida<br>";
            return $this->model->saveURL($url);
        } else {
            echo "URL inválida: " . htmlspecialchars($url) . "<br>";
            throw new Exception("La URL ingresada no es válida");
        }
    }

    public function getAllURLs() {
        echo "Recuperando todas las URLs<br>";
        $urls = $this->model->getAllURLs();
        echo "URLs recuperadas: <pre>" . print_r($urls, true) . "</pre>";
        return $urls;
    }
}
