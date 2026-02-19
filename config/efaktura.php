<?php

return [
    'base_url' => env('EFAKTURA_BASE_URL'),
    'api_key' => env('EFAKTURA_API_KEY'),
    'client_id' => env('EFAKTURA_CLIENT_ID'),
    'client_secret' => env('EFAKTURA_CLIENT_SECRET'),
    'token_url' => env('EFAKTURA_TOKEN_URL'),
    'environment' => env('EFAKTURA_ENVIRONMENT', 'production'),
];
