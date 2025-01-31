<?php
/* Path: public/get_data.php */

/**
 * Clase EndpointValidator
 * Valida la URL del endpoint.
 */
class EndpointValidator {
    /**
     * Valida si un endpoint es válido.
     *
     * @param string $endpoint La URL del endpoint a validar.
     * @return bool True si es válido, False en caso contrario.
     */
    public function validate(string $endpoint): bool {
        return !empty($endpoint) && filter_var($endpoint, FILTER_VALIDATE_URL) !== false;
    }
}

/**
 * Clase GetDataService
 * Maneja la lógica para devolver datos del endpoint.
 */
class GetDataService {
    private $validator;

    /**
     * Constructor
     * @param EndpointValidator $validator Instancia del validador.
     */
    public function __construct(EndpointValidator $validator) {
        $this->validator = $validator;
    }

    /**
     * Procesa la solicitud y genera una respuesta JSON.
     */
    public function processRequest() {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {
            $endpoint = 'http://192.168.0.118:5000';


            if (!$this->validator->validate($endpoint)) {
                throw new Exception('El endpoint es inválido o está vacío');
            }

            $data = [
                'endpoint' => $endpoint,
                'timestamp' => date('Y-m-d H:i:s')
            ];

            echo json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            $errorData = [
                'error' => 'Error al obtener endpoint',
                'message' => $e->getMessage()
            ];
            echo json_encode($errorData);
        }
    }
}

// Inicializar dependencias
$validator = new EndpointValidator();
$service = new GetDataService($validator);

// Procesar la solicitud
$service->processRequest();
