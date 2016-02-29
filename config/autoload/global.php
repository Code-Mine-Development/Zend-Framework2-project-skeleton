<?php
return array(
    'router' => array(
        'routes' => array(),
    ),
    'db' => array(
        'driver' => 'Pdo',
        'database' => false,
        'hostname' => false,
        'dsn' => 'pgsql:dbname=;host=',
        'username' => false,
        'password' => false,
        'adapters' => array(
            'PostgreSQL' => array(
                'database' => false,
                'driver' => 'Pgsql',
                'hostname' => false,
                'username' => false,
                'password' => false,
                'dsn' => 'pgsql:dbname=;host=',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\\Db\\Adapter\\Adapter' => 'Zend\\Db\\Adapter\\AdapterServiceFactory',
        ),
    ),
    'zf-oauth2' => array(
        'options' => array(
            'always_issue_new_refresh_token' => true,
        ),
    ),
    'zf-mvc-auth' => array(
        'authentication' => array(
            'map' => array(
                'Api\\V1' => 'postgresql',
            ),
            'adapters' => array(),
        ),
    ),
    'rollbar' => array(
        'access_token' => false,
        'environment' => 'production',
    ),
    'zf-content-negotiation' => array(
        'selectors' => array(),
    ),
);
