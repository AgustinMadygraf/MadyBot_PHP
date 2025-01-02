<!--
Path: app/models/URLModel.php

-->

<?php
require_once __DIR__ . '/../../config/database.php';

class URLModel {
    private $conn;

    public function __construct() {
        echo "Inicializando el modelo URLModel<br>";
        $database = new Database();
        $this->conn = $database->getConnection();
        if ($this->conn) {
            echo "Conexión a la base de datos establecida<br>";
        } else {
            echo "Error al establecer la conexión a la base de datos<br>";
        }
    }

    public function saveURL($url) {
        echo "Intentando guardar la URL: " . htmlspecialchars($url) . "<br>";
        try {
            $query = "INSERT INTO urls (url, fecha_registro) VALUES (:url, NOW())";
            echo "Consulta SQL para insertar: " . $query . "<br>";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':url', $url);
            $resultado = $stmt->execute();
            echo $resultado ? "URL guardada exitosamente<br>" : "Fallo al guardar la URL<br>";
            return $resultado;
        } catch (PDOException $e) {
            echo "Excepción al guardar la URL: " . htmlspecialchars($e->getMessage()) . "<br>";
            throw new Exception("Error al guardar la URL: " . $e->getMessage());
        }
    }

    public function getAllURLs() {
        echo "Intentando recuperar todas las URLs<br>";
        try {
            $query = "SELECT * FROM urls ORDER BY id DESC";
            echo "Consulta SQL para obtener: " . $query . "<br>";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $urls = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "URLs recuperadas: <pre>" . print_r($urls, true) . "</pre>";
            return $urls;
        } catch (PDOException $e) {
            echo "Excepción al obtener las URLs: " . htmlspecialchars($e->getMessage()) . "<br>";
            throw new Exception("Error al obtener las URLs: " . $e->getMessage());
        }
    }
}
