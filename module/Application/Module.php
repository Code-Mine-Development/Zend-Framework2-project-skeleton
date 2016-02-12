<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

/**
 * Class Module
 * @package Application
 */
class Module
{
    /**
     * @param \Zend\Mvc\MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager        = $event->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // Attach Rollbar
        $rollbarConfig = $event->getApplication()->getServiceManager()->get('config')['rollbar'];
        \Rollbar::init($rollbarConfig, FALSE);

        $sharedManager = $event->getApplication()->getEventManager()->getSharedManager();
        $sharedManager->attach(
            'Zend\Mvc\Application', 'dispatch.error',
            function (MvcEvent $event) {
                if ($event->getParam('exception')) {
                    \Rollbar::report_exception($event->getParam('exception'));
                }
            }
        );
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }


}
