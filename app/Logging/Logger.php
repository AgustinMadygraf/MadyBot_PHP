<?php
/* Path: app/Logging/Logger.php */

namespace App\Logging;

use Exception;

/**
 * Class Logger
 * Handles logging of exceptions and other application events.
 */
class Logger
{
    /**
     * Log an exception to a file.
     *
     * @param Exception $exception
     * @return void
     */
    public static function logException(Exception $exception): void
    {
        $logFile = __DIR__ . '/../../logs/' . date('Y-m-d') . '.log';
        $logMessage = sprintf(
            "[%s] %s in %s on line %d\nStack trace:\n%s\n\n",
            date('Y-m-d H:i:s'),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    /**
     * Log a custom message to a file.
     *
     * @param string $message
     * @return void
     */
    public static function logMessage(string $message): void
    {
        $logFile = __DIR__ . '/../../logs/' . date('Y-m-d') . '.log';
        $logMessage = sprintf("[%s] %s\n", date('Y-m-d H:i:s'), $message);

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
}