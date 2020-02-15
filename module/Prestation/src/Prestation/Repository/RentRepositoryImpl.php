<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/06/2019
 * Time: 16:04
 */

namespace Prestation\Repository;


use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;

class RentRepositoryImpl implements RentRepository
{

    protected $table = 'louer';
    use AdapterAwareTrait;


    /**
     * @param $data
     * @return false|mixed
     */
    public function isFree($data)
    {
        // TODO: Implement isFree() method.
    }

    /**
     * @param $p_id
     * @param $pd_id
     * @param $p_host_id
     * @param $p_host_price
     * @@return null|mixed
     */
    public function save($p_id, $pd_id, $p_host_id, $p_host_price)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $location_id =null;
        var_dump('c parti pour lacat');
/*        try {
            $this->adapter->getDriver()->getConnection()->beginTransaction();

            $insert = $sql->insert()->values(
                array(
                    'p_id' => $p_id,
                    'p_id_prestation' => $p_host_id,
                    'pd_id' => $pd_id,
                    'location_price' => $p_host_price
                ))
                ->into($this->table);
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();

            $location_id = $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();

            $this->adapter->getDriver()->getConnection()->commit();
        }
        catch (\Exception $error ) {
            var_dump($error->getMessage());
            $this->adapter->getDriver()->getConnection()->rollback();
        }*/
        return $location_id;
    }
}