<?php

use Cli\Controller\DocumentControllerFactory;
use Cli\Controller\EventListenerController;

return array(
    'controllers' => [
        'invokables' => [
            EventListenerController::class => EventListenerController::class
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'event --service= --name= --data=' => [
                    'type'    => 'simple',
                    'options' => [
                        'route'    => 'event --service= --name=  --data=',
                        'defaults' => [
                            'controller' => EventListenerController::class,
                            'action'     => 'event',
                        ],
                    ],
                ],
            ],
        ],
    ],
);