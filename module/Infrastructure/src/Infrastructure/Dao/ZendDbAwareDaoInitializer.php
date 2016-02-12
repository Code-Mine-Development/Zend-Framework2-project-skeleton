<?php
/**
 * Created by PhpStorm.
 * User: adamgrabek
 * Date: 23.11.2015
 * Time: 09:32
 */

namespace Infrastructure\Dao;


use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ZendDbAwareDaoInitializer implements InitializerInterface
{
    /**
     * Initialize
     *
     * @param                         $instance
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof ZendDbAwareDaoInterface) {
            $adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
            $instance->setAdapter($adapter);
        }

        return $serviceLocator;
    }

}