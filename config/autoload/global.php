<?php
return array(
    'router'          => array(
        'routes' => array(

        ),
    ),
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
    'service_manager' => array(
        'factories' => array(
            'Zend\\Db\\Adapter\\Adapter' => 'Zend\\Db\\Adapter\\AdapterServiceFactory',
        ),
    ),
    'zf-oauth2'       => array(
        'options' => array(
            'always_issue_new_refresh_token' => TRUE,
        ),
    ),
    'zf-mvc-auth'     => array(
        'authentication' => array(
            'map'      => array(
                'Api\\V1' => 'postgresql',
            ),
            'adapters' => [

            ],
        ),
    ),
    'rollbar'         => array(
        'access_token' => getenv('ROLLBAR_TOKEN'),
        'environment'  => 'production',
    ),
);
