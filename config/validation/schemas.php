<?php

return [
    'webhook' => [
        'required' => ['event', 'timestamp', 'data'],
        'type' => [
            'event' => 'string',
            'timestamp' => 'integer',
            'data' => 'array',
        ],
    ],

    // Additional schemas for other webhook types can be added here
];