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
            'Api\\V1\\Rest\\Balance\\BalanceResource' => 'Api\\V1\\Rest\\Balance\\BalanceResourceFactory',
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
            'api.rest.balance' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/balance[/:balance_id]',
                    'defaults' => array(
                        'controller' => 'Api\\V1\\Rest\\Balance\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            1 => 'api.rpc.health',
            0 => 'api.rest.balance',
        ),
    ),
    'zf-rest' => array(
        'Api\\V1\\Rest\\Balance\\Controller' => array(
            'listener' => 'Api\\V1\\Rest\\Balance\\BalanceResource',
            'route_name' => 'api.rest.balance',
            'route_identifier_name' => 'balance_id',
            'collection_name' => 'balance',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Api\\V1\\Rest\\Balance\\BalanceEntity',
            'collection_class' => 'Api\\V1\\Rest\\Balance\\BalanceCollection',
            'service_name' => 'Balance',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Api\\V1\\Rpc\\Health\\Controller' => 'Json',
            'Api\\V1\\Rest\\Balance\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Api\\V1\\Rpc\\Health\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Api\\V1\\Rest\\Balance\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Api\\V1\\Rpc\\Health\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'Api\\V1\\Rest\\Balance\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Api\\V1\\Rest\\Balance\\BalanceEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.balance',
                'route_identifier_name' => 'balance_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Api\\V1\\Rest\\Balance\\BalanceCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.balance',
                'route_identifier_name' => 'balance_id',
                'is_collection' => true,
            ),
        ),
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
