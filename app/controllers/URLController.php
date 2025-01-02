<?php
require_once __DIR__ . '/../models/URLModel.php';

class URLController {
    private $model;

    public function __construct() {
        $this->model = new URLModel();
    }

    public function saveURL($url) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->model->saveURL($url);
        } else {
            throw new Exception("La URL ingresada no es válida");
        }
    }

    public function getAllURLs() {
        return $this->model->getAllURLs();
    }
}
