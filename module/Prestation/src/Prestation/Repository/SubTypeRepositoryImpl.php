<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 05/09/2018
 * Time: 18:09
 */

namespace Prestation\Repository;


use Prestation\Entity\Hydrator\SubTypeHydrator;
use Prestation\Entity\SubType;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\ClassMethods;

class SubTypeRepositoryImpl implements SubTypeRepository
{

    use AdapterAwareTrait;
    /**
     * @param \Prestation\Entity\SubType $subType
     * @return int|null
     */
    public function save($subType)
    {
        try {
            $sql = new \Zend\Db\Sql\Sql($this->adapter);
            $insert = $sql->insert()
                ->values(array(
                    'st_name' => $subType->getName(),
                    'k_id' => $subType->getKId()
                ))
                ->into('sub_type');
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
            return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        } catch( \Exception $e ) {
            return null;
        }

    }

    /**
     * @return \Prestation\Entity\SubType[] $subType
     */
    public function fetch()
    {

        $sql = new \Zend\Db\Sql\Sql($this->adapter);

        $where = new \Zend\Db\Sql\Where();
        $where->addPredicate(new \Zend\Db\Sql\Predicate\Expression('n.id = st.st_id'));

        $selectSlug = $sql->select();
        $selectSlug
            ->from(array('s' => 'slug'))
            ->columns(array( new \Zend\Db\Sql\Expression("CONCAT(s.s_id,':', s.s_name)") ))
            ->where('s.s_id = n.s_id');

        $selectNamer = $sql->select();
        $selectNamer
            ->from(array('n'=>'namer'))
            ->columns(array( 'slug' => new \Zend\Db\Sql\Expression("GROUP_CONCAT(?)", array($selectSlug)) ))
            ->where($where);

        $selectSubType = $sql->select();
        $selectSubType
            ->from(array('st' => 'sub_type'))
            ->columns(
                array(
                    'st_id',
                    'st_name',
                    'slugs' => new \Zend\Db\Sql\Expression("?", array($selectNamer))
                )
            );
        $statment = $sql->prepareStatementForSqlObject($selectSubType);
        $results = $statment->execute();
        $resultSets = new HydratingResultSet(new SubTypeHydrator(), new SubType());
        $resultSets->initialize($results);

        return $resultSets->toArray();
    }
    /**
     * @param $id
     * @return SubType $subType|null
     */
    public function findById($id)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select()
            ->columns(array('*'))
            ->from('sub_type')
            ->where(array(
                'st_id' => $id
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $results = $statment->execute();
        $resultSets = new HydratingResultSet(new SubTypeHydrator(), new SubType());
        $resultSets->initialize($results);
        return ($resultSets->count() > 0 ? $resultSets->current() : null);
    }


    /**
     * @param \Prestation\Entity\SubType $subType
     * @return mixed
     */
    public function update($subType)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $update = $sql->update('sub_type')
            ->set(
                array('st_name' => $subType->getName())
            )
            ->where(
                array('st_id' => $subType->getId())
            );
        $statment = $sql->prepareStatementForSqlObject($update);
        $statment->execute();

    }

    /**
     * @param $name
     * @return \Prestation\Entity\SubType|null
     */
    public function findByName($name)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select()
            ->columns(array('*'))
            ->from('sub_type')
            ->where(array(
                'st_name' => $name
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $results = $statment->execute();
        $resultSets = new HydratingResultSet(new SubTypeHydrator(), new SubType());
        $resultSets->initialize($results);
        return ($resultSets->count() > 0 ? $resultSets->current() : null);
    }
}