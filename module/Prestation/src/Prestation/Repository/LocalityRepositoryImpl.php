<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 16:57
 */

namespace Prestation\Repository;


use Prestation\Entity\Hydrator\LocalityHydrator;
use Prestation\Entity\Locality;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class LocalityRepositoryImpl implements LocalityRepository
{

    use AdapterAwareTrait;
    public $table = 'locality';
    /**
     * @param \Prestation\Entity\Locality $locality
     * @return int|null
     */
    public function create($locality)
    {
        try{
            $sql = $this->getSql();
            $insert = $sql->insert($this->table)
                ->values(array(
                    'l_name' => $locality->getName(),
                    'l_postcode' => $locality->getPostcode(),
                    'k_id' => $locality->getKId()
                ));
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
            return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        } catch (\Exception $e ) {
            return null;
        }

    }

    /**
     * @param $name
     * @return \Prestation\Entity\Locality|null
     */
    public function findByName($name)
    {
        $sql = $this->getSql();
        $select = $sql->select($this->table)
                ->columns(array('*'))
                ->where(array(
                    'l_name' =>$name
                ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new LocalityHydrator(), new Locality());
        $resultSet->initialize($result);

        return $resultSet->count() > 0 ? $resultSet->current(): null;

    }

    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }
}