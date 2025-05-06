<?php
/* Path: config/sensitive_data.php  */

return [
    // Define sensitive data fields that should be sanitized in logs
    'sensitive_fields' => [
        'password',
        'credit_card_number',
        'ssn', // Social Security Number
        'api_key',
        'access_token',
        'refresh_token',
        'email',
    ],

    // Define a replacement string for sensitive data
    'replacement' => '[REDACTED]',
];