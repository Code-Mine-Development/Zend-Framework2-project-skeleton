<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Translation\\V1\\Rest\\Translation\\TranslationResource' => 'Translation\\V1\\Rest\\Translation\\TranslationResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'translation.rest.translation' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/translation[/:translation_id]',
                    'defaults' => array(
                        'controller' => 'Translation\\V1\\Rest\\Translation\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'translation.rest.translation',
        ),
    ),
    'zf-rest' => array(
        'Translation\\V1\\Rest\\Translation\\Controller' => array(
            'listener' => 'Translation\\V1\\Rest\\Translation\\TranslationResource',
            'route_name' => 'translation.rest.translation',
            'route_identifier_name' => 'translation_id',
            'collection_name' => 'translation',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
                4 => 'POST',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Translation\\V1\\Rest\\Translation\\TranslationEntity',
            'collection_class' => 'Translation\\V1\\Rest\\Translation\\TranslationCollection',
            'service_name' => 'Translation',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Translation\\V1\\Rest\\Translation\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Translation\\V1\\Rest\\Translation\\Controller' => array(
                0 => 'application/vnd.translation.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Translation\\V1\\Rest\\Translation\\Controller' => array(
                0 => 'application/vnd.translation.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Translation\\V1\\Rest\\Translation\\TranslationEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'translation.rest.translation',
                'route_identifier_name' => 'translation_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Translation\\V1\\Rest\\Translation\\TranslationCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'translation.rest.translation',
                'route_identifier_name' => 'translation_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Translation\\V1\\Rest\\Translation\\Controller' => array(
            'input_filter' => 'Translation\\V1\\Rest\\Translation\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Translation\\V1\\Rest\\Translation\\Validator' => array(),
    ),
);
