<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/06/2019
 * Time: 11:58
 */

namespace Prestation\Repository;


use Prestation\Entity\Hydrator\SportCategoryHydrator;
use Prestation\Entity\SportCategory;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class SportsCategoryRepositoryImpl implements SportCategoryRepository
{

    use AdapterAwareTrait;
    public $table = 'category_sport';
    /**
     * @param \Prestation\Entity\SportCategory $sports
     * @return null|int
     */
    public function save($sports)
    {
        // TODO: Implement save() method.
        try {
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->values(array(
                    'c_s_name' => $sports->getName(),
                    'k_id' => $sports->getKId()
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
     * @return \Prestation\Entity\SportCategory|null
     */
    public function findByName($name)
    {
        $sql = $this->getSql();
        $select = $sql->select()
            ->columns(array('*'))
            ->from($this->table)
            ->where(array(
                'c_s_name' => $name
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new SportCategoryHydrator(), new SportCategory());
        $resultSet->initialize($result);

        return $resultSet->count() > 0 ? $resultSet->current(): null;
    }

    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }
}