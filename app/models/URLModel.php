<?php
require_once __DIR__ . '/../../config/database.php';

class URLModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function saveURL($url) {
        try {
            $query = "INSERT INTO urls (url, fecha_registro) VALUES (:url, NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':url', $url);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al guardar la URL: " . $e->getMessage());
        }
    }

    public function getAllURLs() {
        try {
            $query = "SELECT * FROM urls ORDER BY id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener las URLs: " . $e->getMessage());
        }
    }
}
