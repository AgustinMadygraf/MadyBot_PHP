<?php

namespace App\Repositories;

use PDO;
use PDOException;
use App\Interfaces\IURLRepository;

/**
 * Clase URLRepository
 * Implementa la interfaz IURLRepository para manejar operaciones sobre URLs en la base de datos.
 */
class URLRepository implements IURLRepository
{
    /**
     * @var PDO Conexión a la base de datos
     */
    private PDO $connection;

    /**
     * Constructor
     *
     * @param PDO $connection Una instancia de PDO para interactuar con la base de datos.
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Guarda una URL en la base de datos.
     *
     * @param string $url La URL a guardar.
     * @return bool True si se guardó correctamente, False en caso contrario.
     */
    public function saveURL(string $url): bool
    {
        try {
            $query = "INSERT INTO urls (url, fecha_registro) VALUES (:url, NOW())";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Loguear el error según corresponda
            return false;
        }
    }

    /**
     * Recupera todas las URLs almacenadas.
     *
     * @return array Un arreglo de URLs.
     */
    public function getAllURLs(): array
    {
        try {
            $query = "SELECT id, url, fecha_registro FROM urls";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Loguear el error según corresponda
            return [];
        }
    }

    /**
     * Recupera la última URL almacenada en la base de datos.
     *
     * @return string|null La última URL o null si no hay registros.
     */
    public function getLastURL(): ?string
    {
        try {
            $query = "SELECT url FROM urls ORDER BY id DESC LIMIT 1";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['url'] : null;
        } catch (PDOException $e) {
            // Loguear el error según corresponda
            return null;
        }
    }
}
