<?php
/**
 * Created by PhpStorm.
 * User: adamgrabek
 * Date: 23.11.2015
 * Time: 09:07
 */

namespace Infrastructure\Dao;


use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Interface ZendTableGatewayAwareDaoInterface
 *
 * @package Infrastructure\Dao
 */
interface ZendTableGatewayAwareDaoInterface extends DaoInterface
{
    /**
     * @return string
     */
    public function tableName();

    /**
     * @return \Zend\Db\TableGateway\TableGatewayInterface
     */
    public function getGateway();

    /**
     * @param \Zend\Db\TableGateway\TableGatewayInterface $gatewayInterface
     *
     * @return void
     */
    public function setGateway(TableGatewayInterface $gatewayInterface);
}