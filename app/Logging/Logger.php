<?php
/* Path: app/Logging/Logger.php */

namespace App\Logging;

use Exception;
use Utilities\DataSanitizer;

/**
 * Class Logger
 * Handles logging of exceptions and other application events.
 */
class Logger
{
    /**
     * @var DataSanitizer
     */
    private static $sanitizer;

    /**
     * Initialize the Logger with a DataSanitizer instance.
     */
    public static function initialize(): void
    {
        self::$sanitizer = new DataSanitizer();
    }

    /**
     * Log an exception to a file with sanitization.
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
            self::$sanitizer->sanitizeString($exception->getMessage()),
            $exception->getFile(),
            $exception->getLine(),
            self::$sanitizer->sanitizeString($exception->getTraceAsString())
        );

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    /**
     * Log a custom message to a file with sanitization.
     *
     * @param string $message
     * @return void
     */
    public static function logMessage(string $message): void
    {
        $logFile = __DIR__ . '/../../logs/' . date('Y-m-d') . '.log';
        $logMessage = sprintf("[%s] %s\n", date('Y-m-d H:i:s'), self::$sanitizer->sanitizeString($message));

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
}