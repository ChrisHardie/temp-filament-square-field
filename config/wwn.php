<?php

return [
    'integrations' => [
        'square' => [
            'app_id' => env('SQUARE_APP_ID'),
            'access_token' => env('SQUARE_ACCESS_TOKEN'),
            'location_id' => env('SQUARE_LOCATION_ID'),
        ],
    ],
];
