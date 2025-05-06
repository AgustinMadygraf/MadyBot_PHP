<?php
/* Path: src/Http/StatusCode.php */

namespace Http;

/**
 * StatusCode Utility
 * Provides methods to manage HTTP status codes and their associated messages.
 */
class StatusCode
{
    /**
     * @var array $statusCodes Mapping of scenarios to HTTP status codes.
     */
    private static $statusCodes;

    /**
     * Load status codes from configuration.
     */
    public static function loadStatusCodes()
    {
        if (is_null(self::$statusCodes)) {
            self::$statusCodes = include __DIR__ . '/../../../config/http_status_codes.php';
        }
    }

    /**
     * Get the HTTP status code for a given scenario.
     *
     * @param string $scenario The scenario key.
     * @return int|null The HTTP status code, or null if not found.
     */
    public static function getCode(string $scenario): ?int
    {
        self::loadStatusCodes();
        return self::$statusCodes[$scenario] ?? null;
    }

    /**
     * Get the message for a given HTTP status code.
     *
     * @param int $code The HTTP status code.
     * @return string The associated message.
     */
    public static function getMessage(int $code): string
    {
        $messages = [
            200 => 'OK',
            201 => 'Created',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            409 => 'Conflict',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        ];

        return $messages[$code] ?? 'Unknown Status';
    }
}