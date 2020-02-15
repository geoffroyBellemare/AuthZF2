<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/06/2019
 * Time: 23:26
 */

namespace Prestation\Repository;


use Prestation\Entity\Address;
use Prestation\Entity\Hydrator\AddressHydrator;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class AddressRepositoryImpl implements CRUDInterface
{
    use AdapterAwareTrait;
    private $table = 'address';
    /**
     * @param Address $address
     * @return int|null
     */
    public function create($address)
    {
        // TODO: Implement save() method.
        try {
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->values(array(
                    'ad_name' => $address->getName(),
                    'l_id' => $address->getLId(),
                    'c_id' => $address->getCId(),
                    'd_id' => $address->getDId() ? $address->getDId(): null,
                    'r_id' => $address->getRId() ? $address->getRId(): null,
                    'k_id' => $address->getKId()
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
     * @param $name
     * @return Address|mixed|null
     */
    public function findByName($name)
    {
        $sql = $this->getSql();
        $select = $sql->select()
            ->columns(array('*'))
            ->from($this->table)
            ->where(array(
                'ad_name' => $name
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new AddressHydrator(), new Address());
        $resultSet->initialize($result);

        return $resultSet->count() > 0 ? $resultSet->current(): null;
    }
    /**
     * @param $id
     * @return mixed|Address
     */
    public function fetchById($id)
    {
        $sql = $this->getSql();
        $select = $sql->select();
        $select->from(array('ad'=> $this->table))
            ->columns(array('*'))
            ->where(array('ad_id = ?' => $id));

        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet( new AddressHydrator(), new Address());
        $resultSet->initialize($result);

        return $resultSet->current();
    }
    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $target = array('ad_id' => $id);
        $sql = new \Zend\Db\Sql\Sql($this->adapter);

        try {
            $this->adapter->getDriver()->getConnection()->beginTransaction();

            $delete = $sql->delete()->from($this->table)->where($target);
            $statement = $sql->prepareStatementForSqlObject($delete);
            $statement->execute();

            $this->adapter->getDriver()->getConnection()->commit();
        } catch (\Exception $error ){
            $this->adapter->getDriver()->getConnection()->rollback();
        }
    }

    /**
     * @param object $object
     * @return mixed
     */
    public function update($object)
    {
        // TODO: Implement update() method.
    }

    /**
     * @return \Zend\Db\Sql\Sql
     */
    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }

}