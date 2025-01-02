<!--
Path: app/models/URLModel.php

-->

<?php
debug_trace("Inicializando el modelo URLModel");
require_once __DIR__ . '/../helpers/debug_helper.php';
debug_trace("Requeridos los archivos de ayuda");
require_once __DIR__ . '/database.php';
debug_trace("Requerido el archivo de la base de datos");

class URLModel {
    private $conn;

    public function __construct() {
        debug_trace("Inicializando el modelo URLModel");
        $database = new Database();
        $this->conn = $database->getConnection();
        if ($this->conn) {
            debug_trace("Conexión a la base de datos establecida");
        } else {
            debug_trace("Error al establecer la conexión a la base de datos");
        }
    }

    public function saveURL($url) {
        debug_trace("Intentando guardar la URL: " . htmlspecialchars($url));
        try {
            $query = "INSERT INTO urls (url, fecha_registro) VALUES (:url, NOW())";
            debug_trace("Consulta SQL para insertar: " . $query);
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':url', $url);
            $resultado = $stmt->execute();
            debug_trace($resultado ? "URL guardada exitosamente" : "Fallo al guardar la URL");
            return $resultado;
        } catch (PDOException $e) {
            debug_trace("Excepción al guardar la URL: " . htmlspecialchars($e->getMessage()));
            throw new Exception("Error al guardar la URL: " . $e->getMessage());
        }
    }

    public function getAllURLs() {
        debug_trace("Intentando recuperar todas las URLs");
        try {
            $query = "SELECT * FROM urls ORDER BY id DESC";
            debug_trace("Consulta SQL para obtener: " . $query);
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $urls = $stmt->fetchAll(PDO::FETCH_ASSOC);
            debug_trace("URLs recuperadas: " . json_encode($urls));
            return $urls;
        } catch (PDOException $e) {
            debug_trace("Excepción al obtener las URLs: " . htmlspecialchars($e->getMessage()));
            throw new Exception("Error al obtener las URLs: " . $e->getMessage());
        }
    }
}
