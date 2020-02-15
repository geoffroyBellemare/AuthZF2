<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/10/2018
 * Time: 16:29
 */

namespace Prestation\Repository;


use Prestation\Entity\AgeCategory;
use Prestation\Entity\Hydrator\AgeCategoryHydrator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class AgeCategoryRepositoryImpl implements AgeCategoryRepository
{
    use AdapterAwareTrait;
    public $table = 'category_age';
    /**
     * @param \Prestation\Entity\AgeCategory $ageCategory
     * @return mixed
     */
    public function create($ageCategory)
    {
        // TODO: Implement create() method.
       $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
                    ->into($this->table)
                    ->values(array(
                        'c_a_name' => $ageCategory->getName()
                    ));
        $statment = $sql->prepareStatementForSqlObject($insert);
        $result = $statment->execute();

        return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();


    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function findByName($name)
    {
        // TODO: Implement findByName() method.
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select()
            ->from($this->table)
            ->columns(array('*'))
            ->where(array(
                'c_a_name' => $name
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new AgeCategoryHydrator(), new AgeCategory());
        $resultSet->initialize($result);

        return $resultSet->count() > 0 ? $resultSet->current() : null;
    }
}