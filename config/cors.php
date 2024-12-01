<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => explode(',', env('CORS_ALLOWED_ORIGINS')),
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];
