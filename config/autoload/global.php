<?php
return [
    
    'migrations'      => [
        'default' => [
            'prefix'    => '',
        ],
    ],
    'router'          => [
        'routes' => [

        ],
    ],
    'db'              => [
        'driver'   => 'Pdo',
        'database' => getenv('DB_DATABASE'),
        'hostname' => getenv('DB_HOST'),
        'dsn'      => sprintf('pgsql:dbname=%s;host=%s', getenv('DB_DATABASE'), getenv('DB_HOST')),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'adapters' => [
            'PostgreSQL' => [
                'database' => getenv('DB_DATABASE'),
                'driver'   => 'Pgsql',
                'hostname' => getenv('DB_HOST'),
                'username' => getenv('DB_USERNAME'),
                'password' => getenv('DB_PASSWORD'),
                'dsn'      => sprintf('pgsql:dbname=%s;host=%s', getenv('DB_DATABASE'), getenv('DB_HOST')),
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Zend\\Db\\Adapter\\Adapter' => 'Zend\\Db\\Adapter\\AdapterServiceFactory',
        ],
    ],
    'zf-oauth2'       => [
        'options' => [
            'always_issue_new_refresh_token' => TRUE,
        ],
    ],
    'zf-mvc-auth'     => [
        'authentication' => [
            'map'      => [
                'Api\\V1' => 'postgresql',
            ],
            'adapters' => [

            ],
        ],
    ],
    'rollbar'         => [
        'access_token' => getenv('ROLLBAR_TOKEN'),
        'environment'  => 'production',
    ],
];
