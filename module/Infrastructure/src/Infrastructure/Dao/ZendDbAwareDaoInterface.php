<?php
/**
 * Created by PhpStorm.
 * User: adamgrabek
 * Date: 23.11.2015
 * Time: 09:02
 */

namespace Infrastructure\Dao;


use Zend\Db\Adapter\AdapterInterface;

/**
 * Interface ZendDbAwareDaoInterface
 *
 * @package Infrastructure\Dao
 */
interface ZendDbAwareDaoInterface extends DaoInterface
{
    /**
     * @param \Zend\Db\Adapter\AdapterInterface $adapterInterface
     *
     * @return void
     */
    public function setAdapter(AdapterInterface $adapterInterface);

    /**
     * @return \Zend\Db\Adapter\AdapterInterface
     */
    public function getAdapter();
}