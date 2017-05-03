<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' =>  __DIR__ . '/../templates/',
            'settings' => [
                // Prod settings
                // 'cache' => __DIR__ . '/../cache/',
                // Development settings, disable for prod
                'cache' => false,
                'debug' => true,
                'auto_reload' => true
            ]
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Database settings
        'db' => [
            'host' => 'localhost',
            'dbname' => 'glossz',
            'user' => 'alex',
            'pass' => 'alex'
        ]
    ],
];
