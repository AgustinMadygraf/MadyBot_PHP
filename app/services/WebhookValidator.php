<?php

namespace App\Services;

/**
 * Class WebhookValidator
 * Validates the basic structure and required properties of webhooks.
 */
class WebhookValidator extends AbstractValidator
{
    /**
     * Validates the given payload.
     *
     * @param array $payload The payload to validate.
     * @return bool True if the payload is valid, false otherwise.
     */
    public function validate(array $payload): bool
    {
        $this->clearErrors();

        // Check if required fields exist
        if (!isset($payload['event'])) {
            $this->addError('The "event" field is required.');
        }

        if (!isset($payload['timestamp'])) {
            $this->addError('The "timestamp" field is required.');
        }

        if (!isset($payload['data'])) {
            $this->addError('The "data" field is required.');
        }

        // Additional validation logic can be added here

        return empty($this->errors);
    }
}