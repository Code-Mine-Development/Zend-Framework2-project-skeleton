<?php
/**
 * Created by PhpStorm.
 * User: adamgrabek
 * Date: 23.11.2015
 * Time: 09:03
 */

namespace Infrastructure\Dao;


use Zend\Db\Adapter\AdapterInterface;

abstract class AbstractZendDbAwareDao implements ZendDbAwareDaoInterface
{
    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    private $adapter;

    /**
     * @param \Zend\Db\Adapter\AdapterInterface $adapterInterface
     *
     * @return void
     */
    public function setAdapter(AdapterInterface $adapterInterface)
    {
        $this->adapter = $adapterInterface;
    }

    /**
     * @return \Zend\Db\Adapter\AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}