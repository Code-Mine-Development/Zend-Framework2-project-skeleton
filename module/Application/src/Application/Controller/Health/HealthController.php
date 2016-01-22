<?php
/**
 * Creator: adamgrabek
 * Date: 20.01.2016
 * Time: 21:11
 */

namespace Application\Controller\Health;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZF\Hal\Entity;
use ZF\Hal\View\HalJsonModel;

class HealthController extends AbstractActionController
{

    public function handleAction()
    {
        $entity = new \stdClass();
        $entity->ok = 'ok';

        $hal = new Entity($entity, 'd');

        return new JsonModel();
    }

}