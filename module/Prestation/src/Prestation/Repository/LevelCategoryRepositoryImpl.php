<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/10/2018
 * Time: 11:44
 */

namespace Prestation\Repository;


use Prestation\Entity\Hydrator\LevelCategoryHydrator;
use Prestation\Entity\LevelCategory;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class LevelCategoryRepositoryImpl implements  LevelCategoryRepository
{
    use AdapterAwareTrait;
    public $table = 'category_level';

    /**
     * @param \Prestation\Entity\LevelCategory $levelCategory
     * @return mixed
     */
    public function create($levelCategory)
    {
        $sql  = $this->getSql();
        $insert = $sql->insert()
                    ->into($this->table)
                    ->values(array(
                        'c_l_name' => $levelCategory->getName()
                    ));
        $statment = $sql->prepareStatementForSqlObject($insert);
        $statment->execute();

        return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();

    }

    /**
     * @param $name
     * @return \Prestation\Entity\LevelCategory|null
     */
    public function findByName($name)
    {
       $sql = $this->getSql();
       $select = $sql->select()
                    ->from($this->table)
                    ->columns(array('*'))
                    ->where(array('c_l_name' => $name));
       $statment = $sql->prepareStatementForSqlObject($select);
       $result = $statment->execute();
       $resultSet = new HydratingResultSet(new LevelCategoryHydrator(), new LevelCategory());
       $resultSet->initialize($result);

       return $resultSet->count() > 0 ? $resultSet->current() : null;

    }

    /**
     * @return \Zend\Db\Sql\Sql
     */
    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }
}