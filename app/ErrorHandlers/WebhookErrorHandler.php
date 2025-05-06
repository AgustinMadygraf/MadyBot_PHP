<?php
/* Path: app/ErrorHandlers/WebhookErrorHandler.php */

namespace App\ErrorHandlers;

use App\Exceptions\WebhookException;
use App\Exceptions\ValidationException;
use App\Exceptions\AuthenticationException;
use Exception;
use Http\StatusCode;

/**
 * Class WebhookErrorHandler
 * Handles exceptions in a centralized manner.
 */
class WebhookErrorHandler
{
    /**
     * Handle the given exception.
     *
     * @param Exception $exception
     * @return void
     */
    public static function handle(Exception $exception): void
    {
        if ($exception instanceof WebhookException) {
            self::logError($exception);
            http_response_code($exception->getStatusCode());
            echo json_encode(['error' => 'Webhook processing error occurred.']);
        } elseif ($exception instanceof ValidationException) {
            self::logError($exception);
            http_response_code($exception->getStatusCode());
            echo json_encode(['error' => 'Validation error occurred.']);
        } elseif ($exception instanceof AuthenticationException) {
            self::logError($exception);
            http_response_code($exception->getStatusCode());
            echo json_encode(['error' => 'Authentication error occurred.']);
        } else {
            self::logError($exception);
            http_response_code(StatusCode::getCode('internal_server_error'));
            echo json_encode(['error' => 'An unexpected error occurred.']);
        }
    }

    /**
     * Log the exception details.
     *
     * @param Exception $exception
     * @return void
     */
    private static function logError(Exception $exception): void
    {
        error_log($exception->getMessage());
        error_log($exception->getTraceAsString());
    }
}