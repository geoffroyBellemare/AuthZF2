<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 12/10/2018
 * Time: 13:04
 */

namespace Prestation\Repository;


use Prestation\Entity\Hydrator\RegionHydrator;
use Prestation\Entity\Region;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class RegionRepositoryImpl implements RegionRepository
{
    use AdapterAwareTrait;
    public $table = 'region';
    public $tableLink = 'region_linker';
    /**
     * @param \Prestation\Entity\Region $region
     * @return int|null
     */
    public function create($region)
    {
        try {
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->values(array(
                    'r_name' => $region->getName(),
                    'k_id' => $region->getKId()
                ))
                ->into($this->table);
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
            return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();

        } catch( \Exception $e ) {
            return null;
        }
    }

    /**
     * @param \Prestation\Entity\Region $region
     * @return mixed
     */
    public function update($region)
    {
        $sql = $this->getSql();
        $update = $sql->update($this->table)
                ->set(array(
                    'r_name' => $region->getName()
                ))
                ->where(array(
                    'r_id' => $region->getId()
                ));
        $statment = $sql->prepareStatementForSqlObject($update);
        $statment->execute();

    }

    /**
     * @param $id
     * @return array
     */
    public function findById($id)
    {
        $sql = $this->getSql();
        $select = $sql->select()
                ->columns(array('*'))
                ->from($this->table)
                ->where(array('r_id'=> $id));

        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();

        return $result;
    }

    /**
     * @param string $name
     * @return \Prestation\Entity\Region|null
     */
    public function findByName($name)
    {
        // TODO: Implement findByName() method.
        $sql = $this->getSql();
        $select = $sql->select()
            ->columns(array('*'))
            ->from($this->table)
            ->where(array('r_name'=> $name));

        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new RegionHydrator(), new Region());
        $resultSet->initialize($result);

        return $resultSet->count() > 0 ? $resultSet->current(): null;
    }
    /**
     * @param \Prestation\Entity\Region $region
     * @param \Prestation\Entity\Marker $marker
     * @return mixed
     */
    public function createRelation($region, $marker)
    {
        try {
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->into($this->tableLink)
                ->values(array(
                    'r_id' => $region->getId(),
                    'm_id' => $marker->getId()
                ));
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
        } catch ( \Exception $e ) {
        }

    }

    /**
     * @param \Prestation\Entity\Region $region
     * @param \Prestation\Entity\Marker $marker
     * @return mixed|null
     */
    public function findRelation($region, $marker)
    {
        $sql = $this->getSql();
        $select = $sql->select($this->tableLink)
            ->columns(array('*'))
            ->where(array(
                'r_id' => $region->getId(),
                'm_id' => $marker->getId()
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result  = $statment->execute();
        return $result->count() > 0 ? $result->current() : null;
    }
    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $sql = $this->getSql();
        $delete = $sql->delete()
                ->from($this->table)
                ->where(array(
                    'r_id' => $id
                ));
    }

    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }


}