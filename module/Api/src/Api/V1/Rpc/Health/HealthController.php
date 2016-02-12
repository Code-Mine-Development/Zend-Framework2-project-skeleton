<?php
namespace Api\V1\Rpc\Health;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class HealthController extends AbstractActionController
{
    /**
     * @return \Zend\View\Model\JsonModel
     */
    public function healthAction()
    {
        return new JsonModel(['status' => 'ok']);
    }
}
