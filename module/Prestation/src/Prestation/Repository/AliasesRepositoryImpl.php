<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/10/2018
 * Time: 17:12
 */

namespace Prestation\Repository;


use Cocur\Slugify\Slugify;
use Prestation\Entity\Aliases;
use Prestation\Entity\Hydrator\AliasesHydrator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class AliasesRepositoryImpl implements AliasesRepository
{
    use AdapterAwareTrait;
    public $table = 'aliases';
    /**
     * @param \Prestation\Entity\Aliases $aliases
     * @return int|null
     */
    public function create($aliases)
    {
        $id = null;
        $slugify = new Slugify();
        try{
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->into($this->table)
                ->values(array(
                    'a_name' => $slugify->slugify($aliases->getName(), " ")
                ));
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
            $id = $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        } catch(\Exception $e ) {
            $id = null;
        }
        return $id;
    }

    /**
     * @param string $name
     * @return \Prestation\Entity\Aliases|null
     */
    public function findByName($name)
    {
        $sql = $this->getSql();
        $select = $sql->select()
                    ->from($this->table)
                    ->columns(array('*'))
                    ->where(array(
                        'a_name' => $name
                    ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new AliasesHydrator(), new Aliases());
        $resultSet->initialize($result);

        return $resultSet->count() > 0 ? $resultSet->current(): null;


    }

    /**
     * @param $value
     * @return array|null
     */
    public function search($value) {
        $sql = $this->getSql();
        $where = new \Zend\Db\Sql\Where();
        $select = $sql->select();


        $select->from(array('a' => $this->table))
                ->columns(array('*'))
                ->join(
                    array('kl' => 'keyword_linker'),
                    'a.a_id = kl.a_id',
                    array(
                        'k_id',
                        'e_id'
                    ),
                    $select::JOIN_INNER
                );

        $where = $where->like('a_name', '%' . $value . '%');
        $select->where($where);
        $statment = $sql->prepareStatementForSqlObject($select);

        $results = $statment->execute();
        //$resultSets = new HydratingResultSet(new AliasesHydrator(), new Aliases());
       // $resultSets->initialize($results);
        return $results->count() > 0 ? \Zend\Stdlib\ArrayUtils::iteratorToArray($results): null;

    }

    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }
}