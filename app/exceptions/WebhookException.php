<?php
/* Path: app/exceptions/WebhookException.php */

namespace App\Exceptions;

use Exception;
use Http\StatusCode;

/**
 * Class WebhookException
 * Represents exceptions related to webhook processing.
 */
class WebhookException extends Exception
{
    /**
     * Get the associated HTTP status code for this exception.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return StatusCode::getCode('bad_request'); // Example mapping
    }
}