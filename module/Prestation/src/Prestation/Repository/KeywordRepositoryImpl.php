<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/10/2018
 * Time: 15:26
 */

namespace Prestation\Repository;


use Cocur\Slugify\Slugify;
use Prestation\Entity\Hydrator\KeywordHydrator;
use Prestation\Entity\Hydrator\PrestationKeywordsHydrator;
use Prestation\Entity\Keyword;
use Prestation\Entity\Prestation;
use Prestation\Entity\PrestationKeyword;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class KeywordRepositoryImpl implements KeywordRepository
{
    use AdapterAwareTrait;
    public $table = 'keyword';

    /**
     * @param \Prestation\Entity\Keyword $keyword
     * @return int|null
     */
    public function create($keyword)
    {

        $id = null;
        try{
            $slugify = new Slugify();
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->into($this->table)
                ->values(array(
                    'k_name' => $slugify->slugify($keyword->getName(), " ")
                ));
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
            $id = $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        } catch (\Exception $e) {
            $id = null;
        }
        return $id;
    }
    /**
     * @param $a_id
     * @param $e_id
     * @param $k_id
     * @return mixed
     */
    public function createRelation($a_id, $e_id, $k_id)
    {
        try {
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->into('keyword_linker')
                ->values(array(
                    'a_id' => $a_id,
                    'k_id' => $k_id,
                    'e_id' => $e_id
                ));
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
        } catch( \Exception $e ) {
           // var_dump($e->getMessage());
        }
    }
    /**
     * @param $name
     * @return \Prestation\Entity\Keyword|null
     */
    public function findByName($name)
    {
        $sql = $this->getSql();
        $select = $sql->select()
                ->from($this->table)
                ->columns(array('*'))
                ->where(array(
                    'k_name' => $name
                ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resulSet = new HydratingResultSet(new KeywordHydrator(), new Keyword());
        $resulSet->initialize($result);
        return $resulSet->count() > 0 ? $resulSet->current() : null;

    }
    public function searchWithFilterIds($params)
    {
        $firstIteration = true;
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $this->getSelect();
        $where = new \Zend\Db\Sql\Where();
        $having = new \Zend\Db\Sql\Having();

        $where = $where->nest();
        foreach($params as $key => $value) {
            if( $key == 'subtype' || $key == 'q')continue;
            $left = $key[0] .'.k_id';
            $right = $value;
            // var_dump($left);
            if($firstIteration) {
                $firstIteration = false;
                $where = $where->equalTo($left, $right);
            } else {
                $where = $where->and->equalTo($left, $right);
            }
        }
        $where = $where->unnest();

        if(isset($params['subtype']))
            $having->expression("sub_types REGEXP ?", ':'. $params['subtype']. ':');

         $select = $select->where($where)->having($having);

        $statment = $sql->prepareStatementForSqlObject($select);
        $results = $statment->execute();

        $resultSet = new HydratingResultSet(new PrestationKeywordsHydrator(), new PrestationKeyword());
        $resultSet->initialize($results);


        //$data =  $results->count() > 0 ? \Zend\Stdlib\ArrayUtils::iteratorToArray($results): null;/*
        $data = [];
        foreach ($resultSet as $keyword ) {
            $data[] = (array) $keyword;
        }

        return $data;
    }

    private function  getSelect() {

        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();

        $select->from(array('p' => 'prestation'))
            ->columns(array(
                'p_keywords' => $this->getKeywordQuery('kl.k_id = p.k_id'),
                'sub_types' => $this->getSubTypeKeywordAndAliases(),
                // 'commodities' => $this->getSubQueryCommodities()
            ))
            ->join(
                array('t' => 'type'),
                'p.t_id = t.t_id',
                array(
                    't_keywords' => $this->getKeywordQuery('kl.k_id = t.k_id')
                ),
                $select::JOIN_INNER
            )
            ->join(
                array('ml' => 'marker_linker'),
                'p.p_id = ml.p_id',
                array('m_id'),
                $select::JOIN_INNER
            )
            ->join(
                array('m' => 'marker'),
                'ml.m_id = m.m_id',
                array('m_id'),
                $select::JOIN_INNER
            )
            ->join(
                array('l' => 'locality'),
                'l.l_id = m.l_id',
                array(
                    'l_keywords' => $this->getKeywordQuery('kl.k_id = l.k_id')
                ),
                $select::JOIN_INNER
            )
            ->join(
                array('c' => 'country'),
                'c.c_id = m.c_id',
                array(
                    'c_keywords' => $this->getKeywordQuery('kl.k_id = c.k_id')
                ),
                $select::JOIN_INNER
            )
            ->join(
                array('rl' => 'region_linker'),
                'rl.m_id = m.m_id',
                array(
                    'm_id'
                ),
                $select::JOIN_LEFT
            )
            ->join(
                array('r' => 'region'),
                'rl.r_id = r.r_id',
                array(
                    'r_keywords' => $this->getKeywordQuery('kl.k_id = r.k_id')
                ),
                $select::JOIN_LEFT
            )
            ->join(
                array('dl' => 'department_linker'),
                'dl.m_id = m.m_id',
                array(
                    'm_id',
                ),
                $select::JOIN_LEFT
            )
            ->join(
                array('d' => 'department'),
                'dl.d_id = d.d_id',
                array(
                    'd_keywords' => $this->getKeywordQuery('kl.k_id = d.k_id')
                ),
                $select::JOIN_LEFT
            );

        return $select;
    }
    /**
     * @return \Zend\Db\Sql\Sql
     */
    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }

    private function getKeywordQuery($predicate = 'kl.k_id = p.k_id') {
        $selectKeywordName = $this->getSql()->select();
        $selectKeywordName
            ->from(array('a' => 'aliases'))
            ->columns(array('a_name'))
            ->where('a.a_id = kl.a_id');

        $selectKeywordLinker   = $this->getSql()->select();
        $selectKeywordLinker
            ->from(array('kl' => 'keyword_linker'))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(kl.k_id,':',?)", array($selectKeywordName))))
            ->where($predicate);

        return new \Zend\Db\Sql\Expression( '?', array( $selectKeywordLinker ));
    }
    private function getKeywordAliasesQuery($predicate = 'kl.k_id = p.k_id') {
        $selectKeywordName = $this->getSql()->select();
        $selectKeywordName
            ->from(array('a' => 'aliases'))
            ->columns(array(
                'a_name',
            ))
            ->where('a.a_id = kl.a_id');

        $selectKeywordLinker   = $this->getSql()->select();
        $selectKeywordLinker
            ->from(array('kl' => 'keyword_linker'))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(kl.e_id,':',kl.k_id,':',?)", array($selectKeywordName))))
            ->where($predicate);

        return new \Zend\Db\Sql\Expression( '?', array( $selectKeywordLinker ));
    }
    private function  getSubTypeKeywordAndAliases() {
        $selectSubType = $this->getSql()->select();
        $selectSubType
            ->from(array('st' => 'sub_type'))
            ->columns(array(
                new \Zend\Db\Sql\Expression("CONCAT(?)", array($this->getKeywordAliasesQuery('kl.k_id = st.k_id')))
                //'st_name'
            ))
            ->where('st.st_id = stl.st_id');

        $selectSubTypeLinker = $this->getSql()->select();
        $selectSubTypeLinker
            ->from(array('stl' => 'sub_type_linker'))
            //->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(stl.st_id,':',?)", array($selectSubType))))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(?)", array($selectSubType))))
            ->where('stl.p_id = p.p_id');
        return new \Zend\Db\Sql\Expression( '?', array( $selectSubTypeLinker ));
    }

}