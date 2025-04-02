
<?php

use Monolog\Logger;

return [
    'displayErrorDetails' => true,
    'logErrors' => true,
    'logErrorDetails' => true,
    'debug' => true,
    'view' => [
        'template_path' => __DIR__ . '/../resources/views',
        'cache_path' => __DIR__ . '/../storage/cache/views',
    ],
    'logger' => [
        'name' => 'app',
        'path' => __DIR__ . '/../storage/logs/app.log',
        'level' => Logger::DEBUG,
    ]
];
