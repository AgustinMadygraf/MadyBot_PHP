<?php
/*
Path: public/sendMessage.php
*/

ini_set('error_log', __DIR__ . '/../logs/error.log'); // Configura el log en la raíz del proyecto

require_once __DIR__ . '/../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Incluir la base de datos para obtener el endpoint directamente
require_once __DIR__ . '/../app/models/database.php';

// Manejar solicitudes OPTIONS (preflight request)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

/**
 * Class TelegramClient
 *
 * Encapsula el envío de mensajes a Telegram.
 */
class TelegramClient {
    private $botToken;
    private $chatId;

    /**
     * Constructor.
     *
     * @param string $botToken Token del bot.
     * @param string $chatId   ID del chat.
     */
    public function __construct(string $botToken, string $chatId) {
        // Verificar que el token no esté vacío y tenga el formato correcto: número:alfanumérico y/o caracteres permitidos
        if (empty($botToken) || !preg_match('/^\d+:[A-Za-z0-9_-]+$/', $botToken)) {
            error_log("TelegramClient: Token del bot inválido: " . $botToken);
            throw new Exception("Token del bot inválido");
        }
        $this->botToken = $botToken;
        $this->chatId   = $chatId;
        error_log("TelegramClient inicializado. BotToken: " . substr($botToken, 0, 10) . "... ChatID: " . $chatId);
    }

    /**
     * Envía un mensaje a Telegram.
     *
     * @param string $message Mensaje a enviar.
     * @return array Respuesta decodificada del API.
     */
    public function sendMessage(string $message): array {
        $telegramUrl = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
        $data = [
            "chat_id" => $this->chatId,
            "text"    => $message
        ];
        // Log para verificar la configuración y el payload enviado.
        error_log("TelegramClient: Sending to URL: " . $telegramUrl . " Payload: " . json_encode($data));
        
        $options = [
            "http" => [
                "header"       => "Content-Type: application/json",
                "method"       => "POST",
                "content"      => json_encode($data),
                "ignore_errors"=> true  // Permite obtener la respuesta incluso si hay error HTTP
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($telegramUrl, false, $context);
        if ($response === false) {
            $errorInfo = error_get_last();
            $httpHeaders = isset($http_response_header) ? $http_response_header : [];
            error_log("TelegramClient: No se obtuvo respuesta del API de Telegram. Error: " . json_encode($errorInfo) . " Headers: " . json_encode($httpHeaders));
            return [
                "ok" => false,
                "error" => "Sin respuesta de Telegram.",
                "debug" => [
                    "error" => $errorInfo,
                    "headers" => $httpHeaders
                ]
            ];
        }
        $responseData = json_decode($response, true);
        if (!isset($responseData["ok"]) || !$responseData["ok"]) {
            $desc = $responseData["description"] ?? "Error desconocido";
            if (stripos($desc, "chat not found") !== false) {
                $desc .= " - El chat_id utilizado fue: " . $this->chatId . ". Verifique que sea correcto y que el usuario haya iniciado una conversación con el bot.";
            }
            error_log("TelegramClient Error: " . $desc);
        }
        return $responseData;
    }
}

/**
 * Class FastAPIClient
 *
 * Encapsula la comunicación con el endpoint FastAPI.
 */
class FastAPIClient {
    private $endpoint;

    /**
     * Constructor.
     *
     * @param string $endpoint URL del endpoint FastAPI.
     */
    public function __construct(string $endpoint) {
        $this->endpoint = $endpoint;
    }

    /**
     * Envía un mensaje a FastAPI.
     *
     * @param string $message Mensaje a enviar.
     * @return array Respuesta decodificada.
     */
    public function sendMessage(string $message): array {
        $data = ["message" => $message];
        $options = [
            "http" => [
                "header"  => "Content-Type: application/json",
                "method"  => "POST",
                "content" => json_encode($data)
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($this->endpoint, false, $context);
        if ($response === false) {
            error_log("FastAPIClient: Error al comunicarse con FastAPI.");
            return ["reply" => "Error comunicando con FastAPI."];
        }
        return json_decode($response, true);
    }
}

/**
 * Class MessageHandler
 *
 * Orquesta el procesamiento del mensaje usando los clientes.
 */
class MessageHandler {
    private $telegramClient;
    private $fastAPIClient;

    /**
     * Constructor.
     *
     * @param TelegramClient $telegramClient Cliente para Telegram.
     * @param FastAPIClient  $fastAPIClient  Cliente para FastAPI.
     */
    public function __construct(TelegramClient $telegramClient, FastAPIClient $fastAPIClient) {
        $this->telegramClient = $telegramClient;
        $this->fastAPIClient  = $fastAPIClient;
    }

    /**
     * Procesa el mensaje enviándolo a Telegram y luego a FastAPI.
     *
     * @param string $message Mensaje a procesar.
     * @return array Respuesta final.
     */
    public function process(string $message): array {
        $telegramResponse = $this->telegramClient->sendMessage($message);
        if (!isset($telegramResponse["ok"]) || !$telegramResponse["ok"]) {
            $debug = $telegramResponse["debug"] ?? [];
            $errorMsg = $debug["error"]["message"] ?? "Sin detalle";
            $headerInfo = isset($debug["headers"]) ? implode(" | ", $debug["headers"]) : "";
            if ($headerInfo) {
                $errorMsg .= " Headers: " . $headerInfo;
            }
            $errorDesc = $telegramResponse["description"] ?? $errorMsg;
            return [
                "error" => "Error al enviar mensaje a Telegram.",
                "detail" => $errorDesc,
                "telegram_response" => $telegramResponse
            ];
        }
        $fastApiResponse = $this->fastAPIClient->sendMessage($message);
        if (!isset($fastApiResponse["reply"])) {
            return [
                "error" => "Error al comunicarse con FastAPI.",
                "detail" => $fastApiResponse
            ];
        }
        return ["reply" => $fastApiResponse["reply"]];
    }
}

// Configuración del bot y resolución del endpoint FastAPI
$TELEGRAM_BOT_TOKEN = $_ENV['TELEGRAM_BOT_TOKEN'] ?? '';
$TELEGRAM_CHAT_ID   = "593052206"; // ID de chat de Telegram que deberá ser obtenido por un GET o por un POST

try {
    $database = new Database();
    $conn = $database->getConnection();
    $query = "SELECT url FROM urls ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && !empty($result['url'])) {
        if (strpos($result['url'], '/webhook') === false) {
            $FASTAPI_ENDPOINT = rtrim($result['url'], '/') . "/webhook";
        } else {
            $FASTAPI_ENDPOINT = $result['url'];
        }
    }
    error_log("Configuración de WebHook FastAPI: " . $FASTAPI_ENDPOINT); // Registro de debug para WebHook
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    $FASTAPI_ENDPOINT = $defaultEndpoint;
}

// Recibir datos de entrada
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['message'])) {
    echo json_encode(["error" => "No message provided"]);
    exit;
}
$mensaje_usuario = $data['message'];

// Instanciar clientes y procesar el mensaje
$telegramClient = new TelegramClient($TELEGRAM_BOT_TOKEN, $TELEGRAM_CHAT_ID);
$fastAPIClient  = new FastAPIClient($FASTAPI_ENDPOINT);
$messageHandler = new MessageHandler($telegramClient, $fastAPIClient);
$response = $messageHandler->process($mensaje_usuario);
echo json_encode($response);
