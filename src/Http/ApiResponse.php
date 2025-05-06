<?php

namespace App\Http;

/**
 * Class ApiResponse
 * Encapsulates the generation of consistent JSON responses.
 */
class ApiResponse
{
    /**
     * Generates a JSON response for success.
     *
     * @param mixed $data The data to include in the response.
     * @param string $message A success message.
     * @param int $statusCode The HTTP status code (default: 200).
     * @return string JSON-encoded response.
     */
    public static function success($data, string $message = "", int $statusCode = 200): string
    {
        self::setHeaders();
        http_response_code($statusCode);
        return json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Generates a JSON response for errors.
     *
     * @param string $message An error message.
     * @param int $statusCode The HTTP status code (default: 400).
     * @param array|null $errors Additional error details (optional).
     * @return string JSON-encoded response.
     */
    public static function error(string $message, int $statusCode = 400, array $errors = null): string
    {
        self::setHeaders();
        http_response_code($statusCode);
        $response = [
            'status' => 'error',
            'message' => $message
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return json_encode($response);
    }

    /**
     * Sets the appropriate HTTP headers for JSON responses.
     */
    private static function setHeaders(): void
    {
        header('Content-Type: application/json; charset=utf-8');
    }
}