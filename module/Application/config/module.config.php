<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

use Application\Command\Oauth\CreateClientInputFilter;
use Application\Command\User\ActivateUserCommand;
use Application\Command\User\ActivateUserCommandHandler;
use Application\Command\User\ActivateUserCommandHandlerFactory;
use Application\Command\User\ActivateUserInputFilter;
use Application\Command\User\SignupInputFilter;
use Application\Command\User\SignupCommand;
use Application\Command\User\SignupCommandHandler;
use Application\Command\User\SignupCommandHandlerFactory;
use Application\Command\Factory\LoggerMiddlewareFactory;
use Application\Command\Oauth\CreateClientCommand;
use Application\Command\Oauth\CreateClientCommandHandler;
use Application\Command\Oauth\CreateClientCommandHandlerFactory;
use Application\CommandLogger\Formatter;
use Application\CommandLogger\FormatterFactory;
use Application\Factory\DbLoggerFactory;
use Application\Query\User\FetchUserByIdentityQuery;
use Application\Query\User\FetchUserByIdentityQueryHandler;
use Application\Query\User\FetchUserByIdentityQueryHandlerFactory;
use Application\Service\CommandService;
use Application\Service\CommandServiceFactory;
use Application\Service\UserActivationServiceFactory;
use Application\Service\UserActivationServiceInterface;
use League\Tactician\Logger\LoggerMiddleware;
use Zend\Log\Logger;

return [
    'router'          => [
        'routes' => [
            'home' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories'          => [
            CommandService::class                  => CommandServiceFactory::class,
        ],
    ],
    'controllers'     => [
        'invokables' => [
            'Application\Controller\Index' => 'Application\Controller\IndexController',
        ],
    ],
    'view_manager'    => [
        'display_not_found_reason' => TRUE,
        'display_exceptions'       => TRUE,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack'      => [
            __DIR__ . '/../view',
        ],
    ],
    'tactician'       => [
        'handler-map'     => [
        ],
        'inputfilter-map' => [
        ],
        'middleware'      => [
        ],
    ],
    'input_filters'   => array(
        'invokables' => array(
        ),
    ),
];
