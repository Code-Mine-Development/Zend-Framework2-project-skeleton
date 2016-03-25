<?php
/**
 * Created by PhpStorm.
 * User: radek
 * Date: 26.02.16
 * Time: 13:34
 */

namespace Application\Controller;


use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return (new Response())->setContent('OK');
    }

}