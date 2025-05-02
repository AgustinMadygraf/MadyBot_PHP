<?php

namespace App\Interfaces;

/**
 * Interface ValidatorInterface
 * Defines the contract for payload validation classes.
 */
interface ValidatorInterface
{
    /**
     * Validates the given payload.
     *
     * @param array $payload The payload to validate.
     * @return bool True if the payload is valid, false otherwise.
     */
    public function validate(array $payload): bool;

    /**
     * Returns validation errors if any.
     *
     * @return array An array of validation error messages.
     */
    public function getErrors(): array;
}