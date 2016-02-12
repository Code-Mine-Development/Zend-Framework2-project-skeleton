<?php
/**
 * @author Radek Adamiec <radek@code-mine.com>.
 */

namespace Api\V1\Rest;


use League\Tactician\CommandBus;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UpdateDispatcherFactory implements FactoryInterface
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
        $commandBus = $serviceLocator->get(CommandBus::class);

        return new UpdateDispatcher($commandBus);
    }


}