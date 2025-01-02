<?php

// Ensure DebugInterface is defined or imported
interface DebugInterface {
    public function debug(string $message);
}

/**
 * Clase GetDataService 
 * Maneja la lógica para devolver datos del endpoint.
 */
class GetDataService {
    private $validator;
    private $conn;
    private $debugger;

    /**
     * Constructor
     * @param EndpointValidator $validator Instancia del validador.
     * @param PDO $connection Conexión a la base de datos.
     * @param DebugInterface $debugger Instancia del logger para depuración.
     */
    public function __construct(EndpointValidator $validator, PDO $connection, DebugInterface $debugger) {
        $this->validator = $validator;
        $this->conn = $connection;
        $this->debugger = $debugger;
    }

    /**
     * Obtiene la última URL registrada en la base de datos
     */
    private function getLastUrl() {
        try {
            $query = "SELECT url FROM urls ORDER BY id DESC LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->debugger->debug("Consulta ejecutada: $query");
            return $result ? $result['url'] : null;
        } catch (PDOException $e) {
            $this->debugger->debug("Error al obtener la última URL: " . $e->getMessage());
            throw new Exception("Error al obtener la última URL");
        }
    }

    /**
     * Procesa la solicitud y genera una respuesta JSON.
     */
    public function processRequest() {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {
            $endpoint = $this->getLastUrl() ?? 'http://192.168.0.118:5000';
            $this->debugger->debug("Endpoint obtenido: $endpoint");

            if (!$this->validator->validate($endpoint)) {
                throw new Exception('El endpoint es inválido o está vacío');
            }

            $data = [
                'endpoint' => $endpoint,
                'timestamp' => date('Y-m-d H:i:s')
            ];

            echo json_encode($data);
        } catch (Exception $e) {
            $this->debugger->debug("Error procesando la solicitud: " . $e->getMessage());
            http_response_code(500);
            $errorData = [
                'error' => 'Error al obtener endpoint',
                'message' => $e->getMessage()
            ];
            echo json_encode($errorData);
        }
    }
}
