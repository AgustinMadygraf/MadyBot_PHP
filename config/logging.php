<?php
/* Path: config/logging.php  */

return [
    // Define the sanitization level for logs
    // Options: 'none', 'basic', 'strict'
    'sanitization_level' => getenv('LOG_SANITIZATION_LEVEL') ?: 'basic',

    // Define log file path
    'log_file_path' => __DIR__ . '/../logs/',

    // Enable or disable logging
    'enabled' => getenv('LOGGING_ENABLED') !== false ? (bool)getenv('LOGGING_ENABLED') : true,
];