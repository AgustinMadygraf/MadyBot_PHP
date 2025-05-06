<?php
/* Path: config/http_status_codes.php */	


/**
 * HTTP Status Codes Mapping
 * This file defines a mapping between business scenarios and HTTP status codes.
 */

return [
    // Success responses
    'success' => 200, // General success
    'created' => 201, // Resource created successfully

    // Client error responses
    'bad_request' => 400, // Invalid request
    'unauthorized' => 401, // Authentication required
    'forbidden' => 403, // Access denied
    'not_found' => 404, // Resource not found
    'method_not_allowed' => 405, // HTTP method not allowed
    'conflict' => 409, // Conflict in request

    // Server error responses
    'internal_server_error' => 500, // General server error
    'not_implemented' => 501, // Feature not implemented
];