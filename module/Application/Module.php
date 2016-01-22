<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Config\Factory as ConfigFactory;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;
use ZF\Hal\View\HalJsonModel;

/**
 * Class Module
 *
 * @package Application
 */
class Module implements ConfigProviderInterface, BootstrapListenerInterface
{
    /**
     * @param \Zend\EventManager\EventInterface $e
     *
     * @return void
     */
    public function onBootstrap(EventInterface $e)
    {
        if ($e instanceof MvcEvent) {
            $eventManager = $e->getApplication()->getEventManager();
            $moduleRouteListener = new ModuleRouteListener();
            $moduleRouteListener->attach($eventManager);

//            $events = $e->getTarget()->getEventManager();
//            $events->attach(MvcEvent::EVENT_RENDER, function (MvcEvent $event) {
//
//                if (!$event->isError()) {
//                    return;
//                }
//                $currentModel = $event->getResult();
//
//                $exception  = $currentModel->getVariable('exception');
//                $event->setViewModel(new HalJsonModel(['e' => $exception->getMessage()]));
//                $event->setResult(new HalJsonModel(['e' => $exception->getMessage()]));
//            });
        }



    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return ConfigFactory::fromFiles([
            __DIR__ . '/config/controllers.config.yaml',
            __DIR__ . '/config/router.config.yaml',
            __DIR__ . '/config/viewmanager.config.yaml',
            __DIR__ . '/config/servicemanager.config.yaml'
        ], TRUE);
    }

}
