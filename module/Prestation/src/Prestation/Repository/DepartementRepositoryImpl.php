<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 15:33
 */

namespace Prestation\Repository;


use Prestation\Entity\Departement;
use Prestation\Entity\Hydrator\DepartementHydrator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class DepartementRepositoryImpl implements DepartementRepository
{

    use AdapterAwareTrait;
    public $table = 'department';
    public $tableLink = 'department_linker';
    /**
     * @param \Prestation\Entity\Departement $departement
     * @return int|null
     */
    public function create($departement)
    {
        try {
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->values(array(
                    'd_name' => $departement->getName(),
                    'k_id' => $departement->getKId()
                ))
                ->into($this->table);
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
            return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        } catch ( \Exception $e ) {
            return null;
        }
    }
    /**
     * @param \Prestation\Entity\Departement $departement
     * @param \Prestation\Entity\Marker $marker
     * @return mixed|null
     */
    public function findRelation($departement, $marker)
    {

        $sql = $this->getSql();
        $select = $sql->select($this->tableLink)
                    ->columns(array('*'))
                    ->where(array(
                        'd_id' => $departement->getId(),
                        'm_id' => $marker->getId()
                    ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result  = $statment->execute();
        return $result->count() > 0 ? $result->current() : null;


    }
    /**
     * @param \Prestation\Entity\Departement $department
     * @param \Prestation\Entity\Marker $marker
     */
    public function createRelation($department, $marker) {
        try {
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->into($this->tableLink)
                ->values(array(
                    'd_id' => $department->getId(),
                    'm_id' => $marker->getId()
                ));
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
        } catch( \Exception $e ) {

        }
    }
    /**
     * @param $name
     * @return \Prestation\Entity\Departement|null
     */
    public function findByName($name)
    {
        $sql = $this->getSql();
        $select = $sql->select()
                ->columns(array('*'))
                ->from($this->table)
                ->where(array(
                    'd_name' => $name
                ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new DepartementHydrator(), new Departement());
        $resultSet->initialize($result);

        return $resultSet->count() > 0 ? $resultSet->current(): null;
    }

    /**
     * @return mixed
     */
    public function fetchAll()
    {
        $sql = $this->getSql();
        $select = $sql->select()
                ->columns(array('*'))
                ->from($this->table);
        $statment = $sql->prepareStatementForSqlObject($select);
        $results = $statment->execute();
        return $results;
    }

    /**
     * @param \Prestation\Entity\Departement $department
     * @return mixed
     */
    public function update($department)
    {
        $sql = $this->getSql();
        $update = $sql->update($this->table)
                ->set(array(
                    'd_name' => $department->getName()
                ))
                ->where(array(
                'd_id' => $department->getId()
                ));

        $statment = $sql->prepareStatementForSqlObject($update);
        $statment->execute();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $sql = $this->getSql();
        $delete = $sql->delete($this->table)
                ->where(array( 'd_id' => $id));

        $statment = $sql->prepareStatementForSqlObject($delete);
        $statment->execute();
    }

    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }

}