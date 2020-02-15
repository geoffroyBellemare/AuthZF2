<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 19/10/2018
 * Time: 14:03
 */

namespace Prestation\Repository;


use Prestation\Entity\Hydrator\TypeHydrator;
use Prestation\Entity\Type;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class TypeRepositoryImpl implements TypeRepository
{

    use AdapterAwareTrait;
    public $table = 'type';
    /**
     * @param \Prestation\Entity\Type $type
     * @return int|null
     */
    public function create($type)
    {
        try {
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->values(array(
                    't_name' => $type->getName(),
                    'k_id' => $type->getKId()
                ))
                ->into($this->table);
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
            return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        } catch(\Exception $e ) {
            return null;
        }

    }
    /**
     * @param string $name
     * @return \Prestation\Entity\Type|null
     */
    public function findByName($name)
    {
       $sql = $this->getSql();
        $select = $sql->select($this->table)
                    ->columns(array('*'))
                    ->where(array(
                        't_name' => $name
                    ));
        $statment =$sql->prepareStatementForSqlObject($select);
        $result  = $statment->execute();
        $resultSet = new HydratingResultSet(new TypeHydrator(), new Type());
        $resultSet->initialize($result);
        return $result->count() > 0 ? $resultSet->current() : null;
    }

    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }


}