<?php

namespace Application\Command\Quote;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Language\Language;

class AddWordToTranslateCommandHandlerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $language = $serviceLocator->get(Language::class);
        return new AddWordToTranslateCommandHandler($language);

    }
}