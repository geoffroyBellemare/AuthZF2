<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 28/06/2019
 * Time: 18:32
 */

namespace Prestation\Repository;


use Prestation\Entity\Caption;
use Prestation\Entity\Hydrator\CaptionHydrator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class CaptionRepositoryImpl implements CaptionRepository
{
    use AdapterAwareTrait;
    private $table = 'caption';

    /**
     * @param \Prestation\Entity\Caption $object
     * @return int|null
     */
    public function create($caption)
    {
        try {
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->values(array(
                    'caption' => $caption->getCaption(),
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
     * @return Caption|null
     */
    public function findByName($name)
    {
        $sql = $this->getSql();
        $select = $sql->select()
            ->columns(array('*'))
            ->from($this->table)
            ->where(array(
                'caption' => $name
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new CaptionHydrator(), new Caption());
        $resultSet->initialize($result);

        return $resultSet->count() > 0 ? $resultSet->current(): null;
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $target = array('capt_id' => $id);
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
     * @param $id
     * @return Caption
     */
    public function fetchById($id)
    {
        $sql = $this->getSql();
        $select = $sql->select();
        $select->from(array('capt'=> $this->table))
            ->columns(array('*'))
            ->where(array('capt_id = ?' => $id));

        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet( new CaptionHydrator(), new Caption());
        $resultSet->initialize($result);

        return $resultSet->current();
    }

    /**
     * @return \Zend\Db\Sql\Sql
     */
    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }

}