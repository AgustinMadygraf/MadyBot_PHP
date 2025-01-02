<!--
Path: config/database.php
Este archivo PHP se encarga de establecer la conexión con la base de datos.
-->
<?php
class Database {
    private $host = "localhost";
    private $db_name = "mi_base_de_datos";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
