<?php
/* Path: app/exceptions/ValidationException.php */

namespace App\Exceptions;

use Exception;
use Http\StatusCode;

/**
 * Class ValidationException
 * Represents exceptions related to validation errors.
 */
class ValidationException extends Exception
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