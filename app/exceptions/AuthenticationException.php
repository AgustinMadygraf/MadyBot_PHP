<?php
/* Path: app/exceptions/AuthenticationException.php */

namespace App\Exceptions;

use Exception;
use Http\StatusCode;

/**
 * Class AuthenticationException
 * Represents exceptions related to authentication errors.
 */
class AuthenticationException extends Exception
{
    /**
     * Get the associated HTTP status code for this exception.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return StatusCode::getCode('unauthorized'); // Example mapping
    }
}