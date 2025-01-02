<!--
Path: app/models/URLModel.php
-->

<?php
debug_trace("Inicializando el archivo de configuración de la base de datos");
require_once __DIR__ . '/../helpers/debug_helper.php';
debug_trace("Requerido el archivo de ayuda para depuración");
require_once __DIR__ . '/../../vendor/autoload.php';
debug_trace("Requerido el cargador de clases de Composer");


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');

debug_trace("Cargando las variables de entorno");

$dotenv->load();

debug_trace("Cargadas las variables de entorno");

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

            // Verificar si la tabla existe y crearla si no
            $this->createTable();

        } catch (PDOException $exception) {
            debug_trace("Error al conectar con la base de datos: " . $exception->getMessage());
            if (strpos($exception->getMessage(), 'Unknown database') !== false) {
                debug_trace("La base de datos no existe, intentando crearla");
                $this->createDatabase();
                return $this->getConnection(); // Reintentar la conexión después de crear la base de datos
            }
            throw new Exception("Error de conexión: " . $exception->getMessage());
        }
        return $this->conn;
    }

    private function createDatabase() {
        try {
            $dsn = "mysql:host=" . $this->host;
            $conn = new PDO($dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "CREATE DATABASE IF NOT EXISTS " . $this->db_name . " CHARACTER SET utf8 COLLATE utf8_general_ci";
            debug_trace("Ejecutando consulta para crear la base de datos: " . $query);
            $conn->exec($query);
            debug_trace("Base de datos creada exitosamente: " . $this->db_name);
        } catch (PDOException $exception) {
            debug_trace("Error al crear la base de datos: " . $exception->getMessage());
            throw new Exception("Error al crear la base de datos: " . $exception->getMessage());
        }
    }

    private function createTable() {
        try {
            $query = "
                CREATE TABLE IF NOT EXISTS urls (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    url VARCHAR(255) NOT NULL,
                    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB;
            ";
            debug_trace("Ejecutando consulta para crear la tabla: " . $query);
            $this->conn->exec($query);
            debug_trace("Tabla 'urls' creada o ya existía");
        } catch (PDOException $exception) {
            debug_trace("Error al crear la tabla: " . $exception->getMessage());
            throw new Exception("Error al crear la tabla: " . $exception->getMessage());
        }
    }
}