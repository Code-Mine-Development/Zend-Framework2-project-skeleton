<?php
return [
    'modules'                 => include 'modules.config.php',
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
        'config_cache_enabled'     => TRUE,
        'config_cache_key'         => 'tnn',
        'module_map_cache_enabled' => TRUE,
        'module_map_cache_key'     => 'tnn',
        'cache_dir'          => 'data/cache',
        'check_dependencies' => TRUE,
    ],
];
