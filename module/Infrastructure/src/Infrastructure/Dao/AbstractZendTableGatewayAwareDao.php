<?php
/**
 * Created by PhpStorm.
 * User: adamgrabek
 * Date: 23.11.2015
 * Time: 09:08
 */

namespace Infrastructure\Dao;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;

abstract class AbstractZendTableGatewayAwareDao extends AbstractZendDbAwareDao implements ZendTableGatewayAwareDaoInterface
{
    /**
     * @var TableGateway
     */
    private $gateway;

    /**
     * @return \Zend\Db\TableGateway\TableGatewayInterface
     */
    public function getGateway()
    {
        if(null === $this->gateway) {
            $this->gateway = new TableGateway($this->tableName(), $this->getAdapter());
        }

        return $this->gateway;
    }

    /**
     * @param \Zend\Db\TableGateway\TableGatewayInterface $gatewayInterface
     *
     * @return void
     */
    public function setGateway(TableGatewayInterface $gatewayInterface)
    {
        $this->gateway = $gatewayInterface;
    }
}