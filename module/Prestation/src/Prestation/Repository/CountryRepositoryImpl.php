<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 11/10/2018
 * Time: 14:20
 */

namespace Prestation\Repository;


use Prestation\Entity\Country;
use Prestation\Entity\Hydrator\CountryHydrator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class CountryRepositoryImpl implements CountryRepository
{

    use AdapterAwareTrait;
    private $table = 'country';

    /**
     * @param \Prestation\Entity\Country $country
     * @return mixed
     */
    public function create($country)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'c_name' => $country->getName(),
                'c_code' => $country->getCode(),
                'k_id' => $country->getKId()
            ))
        ->into('country');
        $statment = $sql->prepareStatementForSqlObject($insert);
        $statment->execute();

        return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
    }

    /**
     * @param $id
     * @return \Prestation\Entity\Country|null
     */
    public function findById($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select()
            ->columns(array('*'))
            ->from($this->table)
            ->where(array(
                'c_id' => $id
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute($statment);
        return $result->count() > 0 ? $result: null;
    }

    /**
     * @param \Prestation\Entity\Country $country
     * @return mixed|void
     */
    public function update($country)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $update = $sql->update($this->table)
            ->set(array(
                'c_name' => $country->getName(),
                'c_code' => $country->getCode()
            ))
            ->where(array(
                'c_id' => $country->getId()
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
       $sql = new \Zend\Db\Sql\Sql($this->adapter);
       $delete = $sql->delete()
            ->from($this->table)
            ->where(array(
                'c_id' => $id
            ));
       $statment = $sql->prepareStatementForSqlObject($delete);
       $statment->execute();

    }


    /**
     * @param $name
     * @return \Prestation\Entity\Country|null
     */
    public function findByName($name)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select()
            ->columns(array('*'))
            ->from($this->table)
            ->where(array(
                'c_name' => $name
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute($statment);
        $resultSet = new HydratingResultSet(new CountryHydrator(), new Country());
        $resultSet->initialize($result);
        return $resultSet->count() > 0 ? $resultSet->current(): null;
    }
}