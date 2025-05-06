<?php
/* Path: src/Utilities/WebhookPayloadSanitizer.php  */

namespace Utilities;

class WebhookPayloadSanitizer
{
    private $dataSanitizer;

    public function __construct()
    {
        $this->dataSanitizer = new DataSanitizer();
    }

    /**
     * Sanitize sensitive data in a webhook payload.
     *
     * @param array $payload
     * @return array
     */
    public function sanitizePayload(array $payload): array
    {
        return $this->dataSanitizer->sanitizeArray($payload);
    }
}