<?php
/* Path: app/Notifications/ErrorNotifier.php */

namespace App\Notifications;

use Exception;

/**
 * Class ErrorNotifier
 * Sends notifications for critical errors.
 */
class ErrorNotifier
{
    /**
     * Notify about a critical error.
     *
     * @param Exception $exception
     * @return void
     */
    public static function notify(Exception $exception): void
    {
        // Example: Send an email notification (this is a placeholder implementation)
        $to = 'admin@example.com';
        $subject = 'Critical Error Notification';
        $message = sprintf(
            "A critical error occurred:\n\nMessage: %s\nFile: %s\nLine: %d\n\nStack trace:\n%s",
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );
        $headers = 'From: no-reply@example.com' . "\r\n";

        // Use mail() function or any other email library
        mail($to, $subject, $message, $headers);
    }
}