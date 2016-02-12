<?php
/**
 * Created by PhpStorm.
 * User: adamgrabek
 * Date: 23.11.2015
 * Time: 09:20
 */

namespace Infrastructure\Dao;


use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DaoAbstractFactory implements AbstractFactoryInterface
{
    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (class_exists($requestedName, TRUE)) {

            $reflection = new \ReflectionClass($requestedName);

            $interfaces = $reflection->getInterfaceNames();

            foreach ($interfaces as $interface) {

                if ($interface === DaoInterface::class) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return new $requestedName;
    }
}