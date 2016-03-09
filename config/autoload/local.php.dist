<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return [
    'db'              => [
        'driver'   => 'Pdo',
        'dsn'      => sprintf('pgsql:dbname=%s;host=%s', $_SERVER['DB_DATABASE'], $_SERVER['DB_HOST']),
        'username' => $_SERVER['DB_USERNAME'],
        'password' => $_SERVER['DB_PASSWORD'],
        'adapters' => [
            'PostgreSQL' => [
                'database' => $_SERVER['DB_DATABASE'],
                'driver'   => 'Pgsql',
                'hostname' => $_SERVER['DB_HOST'],
                'username' => $_SERVER['DB_USERNAME'],
                'password' => $_SERVER['DB_PASSWORD'],
                'dsn'      => sprintf('pgsql:dbname=%s;host=%s', $_SERVER['DB_DATABASE'], $_SERVER['DB_HOST']),
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Zend\\Db\\Adapter\\Adapter' => 'Zend\\Db\\Adapter\\AdapterServiceFactory',
        ],
    ],
    'zf-mvc-auth'     => [
        'authentication' => [
            'adapters' => [

            ],
        ],
    ],
    'rollbar' => [
        'environment' => 'local'
    ]
];
