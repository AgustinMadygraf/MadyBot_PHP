<?php
/* Path: src/Utilities/DataSanitizer.php  */


namespace Utilities;

class DataSanitizer
{
    private $sensitiveFields;
    private $replacement;

    public function __construct()
    {
        $config = include __DIR__ . '/../../config/sensitive_data.php';
        $this->sensitiveFields = $config['sensitive_fields'] ?? [];
        $this->replacement = $config['replacement'] ?? '[REDACTED]';
    }

    /**
     * Sanitize sensitive data in an array.
     *
     * @param array $data
     * @return array
     */
    public function sanitizeArray(array $data): array
    {
        foreach ($this->sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = $this->replacement;
            }
        }

        return $data;
    }

    /**
     * Sanitize sensitive data in a string (e.g., logs).
     *
     * @param string $log
     * @return string
     */
    public function sanitizeString(string $log): string
    {
        foreach ($this->sensitiveFields as $field) {
            $pattern = sprintf('/"%s":\s*"(.*?)"/i', preg_quote($field, '/'));
            $log = preg_replace($pattern, sprintf('"%s":"%s"', $field, $this->replacement), $log);
        }

        return $log;
    }
}