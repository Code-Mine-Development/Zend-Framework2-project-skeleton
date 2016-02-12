<?php
/**
 * Created by IntelliJ IDEA.
 * Author: Tomasz Osadnik
 * Date: 2015-12-03
 * Time: 12:27
 */

namespace Application\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CommandServiceFactory
 * @package Application\Service
 * @author  Tomasz Osadnik <tomek@code-mine.com>
 */
class CommandServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $inputFilterManager = $serviceLocator->get('InputFilterManager');

        $config         = $serviceLocator->get('Config');
        $inputFilterMap = isset($config['tactician']['inputfilter-map']) ? $config['tactician']['inputfilter-map'] : [];

        $service = new CommandService();
        $service->setInputFilterManager($inputFilterManager);
        $service->setInputFilterMap($inputFilterMap);

        return $service;
    }
}