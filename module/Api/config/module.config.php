<?php
return array(
    'view_manager' => array(
        'template_map' => array(
            'zf-apigility-documentation/operation' => __DIR__ . '/../view/documentation/operation.phtml',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Api\\V1\\Rest\\UpdateDispatcher' => 'Api\\V1\\Rest\\UpdateDispatcherFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'api.rpc.health' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/health',
                    'defaults' => array(
                        'controller' => 'Api\\V1\\Rpc\\Health\\Controller',
                        'action' => 'health',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            1 => 'api.rpc.health',
        ),
    ),
    'zf-rest' => array(),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Api\\V1\\Rpc\\Health\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Api\\V1\\Rpc\\Health\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'Api\\V1\\Rpc\\Health\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(),
    ),
    'zf-content-validation' => array(),
    'zf-mvc-auth' => array(
        'authorization' => array(),
    ),
    'controllers' => array(
        'factories' => array(
            'Api\\V1\\Rpc\\Health\\Controller' => 'Api\\V1\\Rpc\\Health\\HealthControllerFactory',
        ),
    ),
    'zf-rpc' => array(
        'Api\\V1\\Rpc\\Health\\Controller' => array(
            'service_name' => 'Health',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'api.rpc.health',
        ),
    ),
);
