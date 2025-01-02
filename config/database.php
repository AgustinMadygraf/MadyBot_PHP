<!--
Path: config/database.php

-->

<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/helpers/debug_helper.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        debug_trace("Inicializando la clase Database");
        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        debug_trace("Configuración de conexión cargada");
    }

    public function getConnection() {
        $this->conn = null;
        try {
            debug_trace("Intentando establecer la conexión a la base de datos");
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
            debug_trace("Conexión a la base de datos establecida exitosamente");
        } catch (PDOException $exception) {
            debug_trace("Error al conectar con la base de datos: " . $exception->getMessage());
            throw new Exception("Error de conexión: " . $exception->getMessage());
        }
        return $this->conn;
    }
}
