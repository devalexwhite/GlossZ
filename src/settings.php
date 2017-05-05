<?php

//======================================================================
// Provides application settings. There is a seperate file for dev and prod.
//======================================================================

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
        ],
        'prozapi' => [
            'auth_url' => ' https://www.proz.com/oauth/authorize?response_type=code&scope=user.email&',
            'conskey' => 'a987b04bd8eaac13786ddba20f285eed8049856d',
            'conssec' => '6fe7fb6c1924af288444781514eeba73e0bda619',
            'oauth_url' => 'https://www.proz.com/oauth/token',
            'user_url' => 'https://api.proz.com/v2/user'
        ]
    ],
];
