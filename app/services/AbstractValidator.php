<?php

namespace App\Services;

use App\Interfaces\ValidatorInterface;

/**
 * Abstract class AbstractValidator
 * Provides common functionality for payload validation.
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var array Holds validation errors.
     */
    protected array $errors = [];

    /**
     * Returns validation errors if any.
     *
     * @return array An array of validation error messages.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Adds an error message to the errors array.
     *
     * @param string $error The error message to add.
     */
    protected function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * Clears all validation errors.
     */
    protected function clearErrors(): void
    {
        $this->errors = [];
    }
}