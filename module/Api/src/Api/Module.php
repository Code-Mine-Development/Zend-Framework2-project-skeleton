<?php
namespace Api;

use Api\Documentation\ApiDocumentationFactory;
use Api\Security\Listener\AuthenticationListener;
use Infrastructure\Dao\UserDao;
use Zend\Mvc\MvcEvent;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'ZF\Apigility\Autoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * @param \Zend\Mvc\MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {

    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'ZF\Apigility\Documentation\ApiFactory' => function ($services) {

                    $inputFilterManager = $services->get('InputFilterManager');

                    $apiDocumentation = new ApiDocumentationFactory(
                        $services->get('ModuleManager'),
                        $services->get('Config'),
                        $services->get('ZF\Configuration\ModuleUtils')
                    );
                    $apiDocumentation->setInputFilterManager($inputFilterManager);


                    return $apiDocumentation;
                },
            ),
        );
    }
}
