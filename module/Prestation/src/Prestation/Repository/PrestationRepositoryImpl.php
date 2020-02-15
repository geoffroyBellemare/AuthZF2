<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 04/09/2018
 * Time: 19:19
 */

namespace Prestation\Repository;


use Prestation\Entity\Hydrator\AliasesHydrator;
use Prestation\Entity\Hydrator\CountryHydrator;
use Prestation\Entity\Hydrator\DepartementHydrator;
use Prestation\Entity\Hydrator\KeywordHydrator;
use Prestation\Entity\Hydrator\LocalityHydrator;
use Prestation\Entity\Hydrator\Marker2Hydrator;
use Prestation\Entity\Hydrator\MarkerHydrator;
use Prestation\Entity\Hydrator\PrestationHydrator;
use Prestation\Entity\Hydrator\RegionHydrator;
use Prestation\Entity\Hydrator\SubTypeHydrator;
use Prestation\Entity\Hydrator\TypeHydrator;
use Prestation\Entity\Prestation;
use Prestation\Entity\PrestationKeyword;
use Prestation\Utils\DateManipulation;
use Prestation\Utils\Fields;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class PrestationRepositoryImpl implements PrestationRepository
{
    use Fields, AdapterAwareTrait;
    public $table = 'prestation';

    /**
     * @param \Prestation\Entity\Prestation $prestation
     * @return int|null
     */
    public function create2($prestation) {

        $p_id = null;

        try {

            $this->adapter->getDriver()->getConnection()->beginTransaction();

            $sql = new \Zend\Db\Sql\Sql($this->adapter);
            $insert = $sql->insert()->values(
                array(
                    'p_name' => $prestation->getName(),
                    'k_id' => $prestation->getKId(),
                    'p_price' => $prestation->getPrice(),
                    'p_quantity' => $prestation->getQuantity(),
                    'user_id' => $prestation->getUser()->getUserId(),
                    't_id' => $prestation->getType()->getId(),
                    'm_id' => $prestation->getMarker()->getId(),
                    'ad_id' => $prestation->getAddress()->getId(),
                    'capt_id' => $prestation->getCaption()->getId(),
                    'p_created' => time(),
                ))
                ->into('prestation');
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
            $p_id = $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
/*            $this->createRelWithMarker($prestation->getMarker(), $p_id);*/
            $this->createRelWithSubType($prestation, $p_id);
            $this->createRelWithAgeCategory($prestation->getAgeCategory(), $p_id);
            $this->createRelWithLevelCategory($prestation->getLevelCategory(),$p_id);
            $this->createRelWithSportCategory($prestation->getSportCategory(), $p_id);
            $this->adapter->getDriver()->getConnection()->commit();

        } catch (\Exception $e ) {
            var_dump($e->getMessage());
            $this->adapter->getDriver()->getConnection()->rollback();

        }
        return $p_id;
    }
    /**
     * @param \Prestation\Entity\Marker $marker
     * @param \Prestation\Entity\Prestation $prestation
     * @return int|null
     */
    public function create($marker, $prestation)
    {
        // TODO: Implement create() method.

        try {
            $this->adapter->getDriver()->getConnection()->beginTransaction();

            $sql = new \Zend\Db\Sql\Sql($this->adapter);
            $insert = $sql->insert()->values(
                array(
                    'p_name' => $prestation->getName(),
                    'p_price' => $prestation->getPrice(),
                    'p_owner' => $prestation->getOwner(),
                    'p_quantity' => $prestation->getQuantity(),
                    't_id' => $prestation->getType()->getId(),
                    'p_created' => time(),
                ))
                ->into('prestation');
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();

            $p_id = $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();

            $this->createRelWithMarker($prestation->getMarker(), $p_id);
            $this->createRelWithSubType($prestation, $p_id);
           // $this->createRelWithAgeCategory($prestation->getAgeCategory(), $p_id);
            /*  $this->createRelWithLevelCategory($prestation->getLevelCategory(),$p_id);*/

            $this->adapter->getDriver()->getConnection()->commit();
        } catch( \Exception $e ) {
            $this->adapter->getDriver()->getConnection()->rollback();
            return null;
        }


        return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
    }

    /**
     * @param \Prestation\Entity\Marker $marker
     * @param int $p_id
     * @return mixed
     */
    public function createRelWithMarker($marker, $p_id)
    {
        $sqlRel = new \Zend\Db\Sql\Sql($this->adapter);
        $insertRelation = $sqlRel->insert('marker_linker')
            ->values(array(
                'm_id' => $marker->getId(),
                'p_id' => $p_id
            ));
        $statmentRel = $sqlRel->prepareStatementForSqlObject($insertRelation);
        $statmentRel->execute();
    }

    /**
     * @param \Prestation\Entity\Prestation $prestation
     * @param int $p_id
     */
    public function createRelWithSubType($prestation, $p_id) {

        foreach ($prestation->getSubTypes() as $subType) {
            $sqlFilter = new \Zend\Db\Sql\Sql($this->adapter);
            $insertFilter = $sqlFilter->insert('sub_type_linker')
                ->values(array(
                    'p_id' => $p_id,
                    'st_id' => $subType->getId()
                ));
            $filterStatment = $sqlFilter->prepareStatementForSqlObject($insertFilter);
            $filterStatment->execute();
        }
    }
    /**
     * @param \Prestation\Entity\AgeCategory[] $ageCategoryList
     * @param $p_id
     */
    public function createRelWithAgeCategory($ageCategoryList, $p_id = null ) {

        if( $ageCategoryList ) {

           foreach ($ageCategoryList as $ageCategory ) {
                $sql = $this->getSql();
                $insert = $sql->insert()
                    ->into('category_age_linker')
                    ->values(array(
                        'p_id' => $p_id,
                        'c_a_id' => $ageCategory->getId()
                    ));
                $statment = $sql->prepareStatementForSqlObject($insert);
                $statment->execute();
            }
        }
    }
    /**
     * @param \Prestation\Entity\SportCategory[] $sportCategoryList
     * @param $p_id
     */
    public function createRelWithSportCategory($sportCategoryList, $p_id = null ) {

        if( $sportCategoryList ) {

            foreach ($sportCategoryList as $sportCategory ) {
                $sql = $this->getSql();
                $insert = $sql->insert()
                    ->into('category_sport_linker')
                    ->values(array(
                        'p_id' => $p_id,
                        'c_s_id' => $sportCategory->getId()
                    ));
                $statment = $sql->prepareStatementForSqlObject($insert);
                $statment->execute();
            }
        }
    }

    /**
     * @param \Prestation\Entity\LevelCategory[] $levelCategoryList
     * @param null $p_id
     * @return mixed
     */
    public function createRelWithLevelCategory($levelCategoryList, $p_id = null)
    {
        if( $levelCategoryList ) {

            foreach ($levelCategoryList as $levelCategory ) {
                $sql = $this->getSql();
                $insert = $sql->insert()
                    ->into('category_level_linker')
                    ->values(array(
                        'p_id' => $p_id,
                        'c_l_id' => $levelCategory->getId()
                    ));
                $statment = $sql->prepareStatementForSqlObject($insert);
                $statment->execute();
            }
        }
    }
    /**
     * @return \Zend\Db\Sql\Sql
     */
    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }
    /**
     * @param Prestation $prestation
     * @return mixed
     */
    public function save($prestation)
    {

        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        try {
            $this->adapter->getDriver()->getConnection()->beginTransaction();

            $insert = $sql->insert()->values(
                array(
                    'p_name' => $prestation->getName()
                ))
                ->into('prestation');
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();

            $p_id = $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();

            foreach ($prestation->getSubTypes() as $subType) {
                $sqlFilter = new \Zend\Db\Sql\Sql($this->adapter);
                $insertFilter = $sqlFilter->insert('filter')
                    ->values(array(
                        'p_id' => $p_id,
                        'st_id' => $subType->getId()
                    ));
                $filterStatment = $sqlFilter->prepareStatementForSqlObject($insertFilter);
                $filterStatment->execute();
            }
            $this->adapter->getDriver()->getConnection()->commit();
        }
        catch (\Exception $error ) {
            var_dump($error->getMessage());
            $this->adapter->getDriver()->getConnection()->rollback();
        }



    }
    /**
     * @param Prestation $prestation
     * @return mixed
     */
    public function update(Prestation $prestation)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $update = $sql->update('prestation')
            ->set(array(
                'p_name' => $prestation->getName()
            ))
            ->where(array(
                'P_id' => $prestation->getId()
            ));
        $statment = $sql->prepareStatementForSqlObject($update);
        $statment->execute();
    }
    /**
     * @param $data
     * @return false|mixed
     */
    public function isFree($data)
    {
        var_dump('isfree');
        var_dump($data);
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $sql = $this->getSql();
        $select = $sql->select();
        $select
            ->from(array('p'=> 'prestation'))
            ->columns(array('p_id'))
            ->join(
                array('ml' => 'marker_linker'),
                'ml.p_id = p.p_id',
                array('*'),
                $select::JOIN_INNER
            )
            ->join(
                array('pd' => 'period'),
                'p.p_id = pd.p_id',
                array(
                    'pd_start',
                    'pd_end'
                ),
                $select::JOIN_INNER
            )
            ->join(
                array('h' => 'horaire'),
                'h.pd_id = pd.pd_id',
                array(
                    'h_start',
                    'h_end'
                ),
                $select::JOIN_LEFT
            )
            ->join(
                array('m' => 'marker'),
                'ml.m_id = m.m_id',
                array('*'),
                $select::JOIN_INNER
            )
            ->join(
                array('t' => 'type'),
                't.t_id = p.t_id',
                array('*'),
                $select::JOIN_INNER
            )
            ->join(
                array('l' => 'locality'),
                'l.l_id = m.l_id',
                array('*'),
                $select::JOIN_INNER
            )

            ->where(array(
                'p.p_name' => $data['name'],
                'p.t_id' => $data['type'],
                'l.l_name' => $data['locality']
                /*'p.p_id' => $prestation->getId(),
                'pd.pd_start <= ?' => $period->getPdStart(),
                'pd.pd_end >= ?' => $period->getPdEnd(),
                'h.h_start = ?' => $horaire->getHStart()*/
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $results = $statment->execute();
        var_dump($results->current());
        return $results->current();
    }
    /**
     * @param $name
     * @param $locality
     * @param $type
     * @return mixed|null
     */
    public function findByNameAndLocalityWithType($name, $locality, $type)
    {

        $sql= new \Zend\Db\Sql\Sql($this->adapter);
        $select  = $sql->select();
        $select->from(array('p' => $this->table))
            ->columns(
                array(
                    'p_id',
                    'p_name',
                    'p_price',
                    'p_quantity',
                    't_id',
                    'p_created',
                    'm_id',
                    'sub_types' => $this->getSubtypesQuery(),
                    'age_categories' => $this->getSubQueryAgeCategories(),
                    'level_categories' => $this->getSubQueryLevelCategories()
                )
            )
/*           ->join(
                array('ml' => 'marker_linker'),
                'ml.p_id = p.p_id',
                array('*'),
                $select::JOIN_INNER
            )*/
            ->join(
                array('m' => 'marker'),
                'm.m_id = p.m_id',
                array('*'),
                $select::JOIN_INNER
            )

            ->join(
               array('t' => 'type'),
               't.t_id = p.t_id',
               array('*'),
               $select::JOIN_INNER
           )
            ->join(
                  array('l' => 'locality'),
                  'l.l_id = m.l_id',
                  array('*'),
                  $select::JOIN_INNER
                  )
              ->join(
                  array('c' => 'country'),
                  'c.c_id = m.c_id',
                  array('*'),
                  $select::JOIN_INNER
              )
/*              ->join(
                  array('dl' => 'department_linker'),
                  'm.m_id = dl.m_id',
                  array('d_id'),
                  $select::JOIN_LEFT
              )*/
              ->join(
                  array('d' => 'department'),
                  'd.d_id = m.d_id',
                  array('d_name'),
                  $select::JOIN_LEFT
              )
/*              ->join(
                  array('rl' => 'region_linker'),
                  'rl.m_id = m.m_id',
                  array('r_id'),
                  $select::JOIN_LEFT
              )*/
              ->join(
                  array('r' => 'region'),
                  'r.r_id = m.r_id',
                  array('r_name'),
                  $select::JOIN_LEFT
              )
/*            ->join(
                array('cal' => 'category_age_linker'),
                'cal.p_id = p.p_id',
                array('c_a_id'),
                $select::JOIN_LEFT
            )
            ->join(
                array('ca' => 'category_age'),
                'ca.c_a_id = cal.c_a_id',
                array('c_a_name'),
                $select::JOIN_LEFT
            )*/
        ->where(
            array(
                'p.p_name' => $name,
                'p.t_id' => $type,
                'l.l_name' => $locality
            )
        );
        $statment = $sql->prepareStatementForSqlObject($select);

        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new PrestationHydrator(), new Prestation() );
        $resultSet->initialize($result);

        return $resultSet->count() > 0 ? $resultSet->current(): null;
    }
    /**
     * @param $page
     * @return array
     */
    public function fetchByPage($page)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $resultSet = new HydratingResultSet($this->getHydrator(), new Prestation());
        $paginatorAdapter = new \Zend\Paginator\Adapter\DbSelect($this->getSqlfetch($sql),$this->adapter,$resultSet);
        $paginator = new \Zend\Paginator\Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(5);

        return json_decode($paginator->toJson());
    }

    /**
     * @param $k_id
     * @return mixed
     */
    public function search($k_id)
    {
        $selectSubType = $this->getSql()->select();
        $selectSubType
            ->from(array('st' => 'sub_type'))
            ->columns(array(
                new \Zend\Db\Sql\Expression("CONCAT(st.st_name,'#',?)", array($this->getKeywordQuery('kl.k_id = st.k_id')))
                //'st_name'
            ))
            ->where('st.st_id = stl.st_id');

        $selectSubTypeLinker = $this->getSql()->select();
        $selectSubTypeLinker
            ->from(array('stl' => 'sub_type_linker'))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(stl.st_id,':',?)", array($selectSubType))))
            ->where('stl.p_id = p.p_id');

        // new \Zend\Db\Sql\Expression( '?', array( $selectSubTypeLinker ));

        $where = new \Zend\Db\Sql\Where();
        //ici !!!
        $where = $where->equalTo('l.k_id', $k_id);

        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->from(array('p' => 'prestation'))
            ->columns(array(
                'p_id',
                'p_price',
                'p_owner',
                'p_quantity',
                'p_name',
                'p_keywords' => $this->getKeywordQuery('kl.k_id = p.k_id'),
/*                't_id',
                'k_id',
                'p_created',*/
                'sub_types' => new \Zend\Db\Sql\Expression( '?', array( $selectSubTypeLinker )),
               /* 'commodities' => $this->getSubQueryCommodities()*/
            ))
            ->join(
                array('t' => 'type'),
                'p.t_id = t.t_id',
                array(
                    't_id',
                    't_keywords' => $this->getKeywordQuery('kl.k_id = t.k_id')
                ),
                $select::JOIN_INNER
            )
            ->join(
                array('ml' => 'marker_linker'),
                'p.p_id = ml.p_id',
                array('*'),
                $select::JOIN_INNER
            )
            ->join(
                array('m' => 'marker'),
                'ml.m_id = m.m_id',
                array('*'),
                $select::JOIN_INNER
            )
            ->join(
                array('l' => 'locality'),
                'l.l_id = m.l_id',
                array(
                    'l_kewords' => $this->getKeywordQuery('kl.k_id = l.k_id')
                ),
                $select::JOIN_INNER
            )
        ->where($where);
        $statment = $sql->prepareStatementForSqlObject($select);
        $results = $statment->execute();
        $data =  $results->count() > 0 ? \Zend\Stdlib\ArrayUtils::iteratorToArray($results): null;
        var_dump($data);
    }
    /**
     * @return array
     */
    public function fecthAll()
    {
//remetre les contraintes sur marker_linker

        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->from(array('p' => 'prestation'))
            ->columns(array(
                'p_id',
                'p_price',
                'p_owner',
                'p_quantity',
                'p_name',
                't_id',
                'k_id',
                'p_created',
                'sub_types' => $this->getSubtypesQuery(),
                'commodities' => $this->getSubQueryCommodities()
            ))
            ->join(
                array('ml' => 'marker_linker'),
                'p.p_id = ml.p_id',
                array(
                    'markers' => new \Zend\Db\Sql\Expression("GROUP_CONCAT(?)", array($this->getSubQueryMarker())),
                    'departments' => $this->getSubQueryDepartments(),
                    'regions' => $this->getSubQueryRegions()
                ),
                $select::JOIN_INNER
            )
            ->join(
                array('t' => 'type'),
                't.t_id = p.t_id',
                array(
                    't_name',
                    't_k_id' => 'k_id'
                ),
                $select::JOIN_INNER
            );



            /*
[42000][1701] Cannot truncate a table referenced in a foreign key constraint (`zf2course`.`sub_type_linker`, CONSTRAINT `sub_type_linker_sub_type_FK` FOREIGN KEY (`st_id`) REFERENCES `zf2course`.`sub_type` (`st_id`))
                      ->join(
                          array('k' => 'keyword'),
                          'k.k_id = p.k_id',
                          array(
                              'p_k_id'=> 'k_id',
                              'k_name',
                              'aliases' => $this->getKeywordQuery()
                          ),
                          $select::JOIN_INNER
                      )

             */

        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet($this->getHydrator(), new PrestationKeyword());
        $resultSet->initialize($result);
        var_dump($resultSet->current());
/*        $prestations = array();
        foreach ( $resultSet as $item) {
            $prestations[] = $item;
        }
        return $prestations;*/

    }
    private function getHydrator() {
        $hydrator = new AggregateHydrator();
        $hydrator->add(new PrestationHydrator());
        $hydrator->add(new MarkerHydrator());
        $hydrator->add(new DepartementHydrator());
        $hydrator->add(new RegionHydrator());
        $hydrator->add(new SubTypeHydrator());
        $hydrator->add(new TypeHydrator());
/*        $hydrator->add(new KeywordHydrator());
        $hydrator->add(new AliasesHydrator());
        */

        return $hydrator;
    }
    /**
     * @return Prestation|null
     */
    public function fetchByid($id)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $sql= new \Zend\Db\Sql\Sql($this->adapter);
        $select  = $sql->select();
        $select->from(array('p' => $this->table))
            ->columns(
                array(
                    'p_id',
                    'p_name',
                    'p_price',
                    'p_quantity',
                    't_id',
                    'p_created',
                    'm_id',
                    'sub_types' => $this->getSubtypesQuery(),
                    'age_categories' => $this->getSubQueryAgeCategories(),
                    'level_categories' => $this->getSubQueryLevelCategories()
                )
            )
            ->where(array('p.p_id' => $id));
/*        $select = $this->getSqlfetch($sql);
        $select->where(array('p.p_id' => $id));*/
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();

        $resultSet = new HydratingResultSet($this->getHydrator(), new Prestation());
        $resultSet->initialize($result);
        return ( $resultSet->count() > 0 ) ? $resultSet->current() : null;

    }

    private function getSubQueryAgeCategories () {
        $selectAgeCategoryName = $this->getSql()->select();
        $selectAgeCategoryName
            ->from(array('ca' => 'category_age'))
            ->columns(array('c_a_name'))
            ->where('ca.c_a_id = cal.c_a_id');

        $selectAgeCategory   = $this->getSql()->select();
        $selectAgeCategory
            ->from(array('cal' => 'category_age_linker'))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(cal.c_a_id,':',?)", array($selectAgeCategoryName))))
            ->where('cal.p_id = p.p_id');

        return new \Zend\Db\Sql\Expression( '?', array( $selectAgeCategory ));
    }
    private function getSubQueryLevelCategories () {
        $selectLevelCategoryName = $this->getSql()->select();
        $selectLevelCategoryName
            ->from(array('cl' => 'category_level'))
            ->columns(array('c_l_name'))
            ->where('cl.c_l_id = cll.c_l_id');

        $selectLevelCategory   = $this->getSql()->select();
        $selectLevelCategory
            ->from(array('cll' => 'category_level_linker'))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(cll.c_l_id,':',?)", array($selectLevelCategoryName))))
            ->where('cll.p_id = p.p_id');

        return new \Zend\Db\Sql\Expression( '?', array( $selectLevelCategory ));
    }
    /**
     * @return AggregateHydrator
     */


    /**
     * @param $sql
     * @return \Zend\Db\Sql\Select
     */
    private function getSqlfetch($sql) {
        $selectSubType = $sql->select();
        $selectSubType
            ->from(array('st' => 'sub_type'))
            ->columns(array('st_name'))
            ->where('st.st_id = f.st_id');

        $selectFilter   = $sql->select();
        $selectFilter
            ->from(array('f' => 'filter'))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(f.st_id,':',?)", array($selectSubType))))
            ->where('f.p_id = p.p_id');

        $select = $sql->select();
        $select
            ->from(array('p'=>'prestation'))
            ->columns(array(
                'p_id',
                'p_name',
                'sub_types' => new \Zend\Db\Sql\Expression( '?', array( $selectFilter ))
            ));
        return $select;
    }
    /**
     * @return \Zend\Db\Sql\Expression
     */
    private function getSubtypesQuery( ) {
        $selectSubType = $this->getSql()->select();
        $selectSubType
            ->from(array('st' => 'sub_type'))
            ->columns(array(
                'st_name'
            ))
            ->where('st.st_id = stl.st_id');

        $selectSubTypeLinker = $this->getSql()->select();
        $selectSubTypeLinker
            ->from(array('stl' => 'sub_type_linker'))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(stl.st_id,':',?)", array($selectSubType))))
            ->where('stl.p_id = p.p_id');

        return new \Zend\Db\Sql\Expression( '?', array( $selectSubTypeLinker ));
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
    /**
     * @return \Zend\Db\Sql\Select
     */
    private function getSubQueryLocality () {
        $select = $this->getSql()->select()
            ->from(array('l' => 'locality'))
            ->columns(array(
                new \Zend\Db\Sql\Expression("CONCAT(l.l_id,'#',l.l_name,'#',l.l_postcode) as data")
            ))
            ->where('m.l_id = l.l_id');
        return $select;
    }
    private function getSubQueryCountry() {
        $select = $this->getSql()->select()
            ->from(array('c' => 'country'))
            ->columns(array(
                new \Zend\Db\Sql\Expression("CONCAT(c.c_id,'#',c.c_name,'#',c.c_code) as data")
            ))
            ->where('m.c_id = c.c_id');
        return $select;
    }

    private function getSubQueryCommodity() {
        $select = $this->getSql()->select()
            ->from(array('cmd' => 'commodity'))
            ->columns(array(
                new \Zend\Db\Sql\Expression("CONCAT(cmd.cmd_id,':',cmd.cmd_name,':',cmd.cmd_note,':',cmd.cmd_description)")
            ))
            ->where('cmd.cmd_id = cmdl.cmd_id');
        return $select;
    }

    private function  getSubQueryMarker() {
        $select = $this->getSql()->select();
        $select
            ->from(array('m' => 'marker'))
            ->columns(array(
                //Expression('CASE WHEN col_1 = ? THEN ? WHEN col_2 = ? THEN ? WHEN col_3 = ? THEN ? END', array(1, 0, 1, 1, 1, 2))
                new \Zend\Db\Sql\Expression("CONCAT(m.m_id,':',m.lat,':',m.lng,':',?,':',?)", array($this->getSubQueryCountry(), $this->getSubQueryLocality()))
            ))
            ->where('m.m_id = ml.m_id');
        return $select;
    }

    private function  getSubQueryDepartment() {
        $select = $this->getSql()->select()
            ->from(array('d' => 'department'))
            ->columns(array(
                new \Zend\Db\Sql\Expression("CONCAT(dl.m_id,':',d.d_id,':',d.d_name) as data")
            ))
            ->where('d.d_id = dl.d_id');
        return $select;
    }
    private function  getSubQueryDepartments() {
        $select = $this->getSql()->select()
            ->from(array('dl' => 'department_linker'))
            ->columns(array(
                new \Zend\Db\Sql\Expression("?", array($this->getSubQueryDepartment()))
            ))
            ->where('dl.m_id = ml.m_id');

        return new \Zend\Db\Sql\Expression("GROUP_CONCAT(?)", array($select));
    }
    private function  getSubQueryRegion() {
        $select = $this->getSql()->select()
            ->from(array('r' => 'region'))
            ->columns(array(
                new \Zend\Db\Sql\Expression("CONCAT(rl.m_id,':',r.r_id,':',r.r_name) as data")
            ))
            ->where('r.r_id = rl.r_id');
        return $select;
    }
    private function  getSubQueryRegions() {
        $select = $this->getSql()->select()
            ->from(array('rl' => 'region_linker'))
            ->columns(array(
                new \Zend\Db\Sql\Expression("?", array($this->getSubQueryRegion()))
            ))
            ->where('rl.m_id = ml.m_id');

        return new \Zend\Db\Sql\Expression("GROUP_CONCAT(?)", array($select));
    }

    private function getSubQueryCommodities() {
        $select = $this->getSql()->select()
            ->from(array('cmdl' => 'commodity_linker'))
            ->columns(array(
                new \Zend\Db\Sql\Expression("GROUP_CONCAT(?)", array($this->getSubQueryCommodity()))
            ))
            ->where('p.p_id = cmdl.p_id');

        return new \Zend\Db\Sql\Expression("GROUP_CONCAT(?)", array($select));
    }


    /**
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $target = array('p_id' => $id);
        $sql = new \Zend\Db\Sql\Sql($this->adapter);

        try {
            $this->adapter->getDriver()->getConnection()->beginTransaction();

            $deleteSubTypeLinker = $sql->delete()->from('sub_type_linker')->where($target);
            $statement = $sql->prepareStatementForSqlObject($deleteSubTypeLinker);
            $statement->execute();

            $deleteAgeCategoryLinker = $sql->delete()->from('category_age_linker')->where($target);
            $statement = $sql->prepareStatementForSqlObject($deleteAgeCategoryLinker);
            $statement->execute();

            $deleteLevelCategoryLinker = $sql->delete()->from('category_level_linker')->where($target);
            $statement = $sql->prepareStatementForSqlObject($deleteLevelCategoryLinker);
            $statement->execute();

            $deleteMarkerLinker = $sql->delete()->from('marker_linker')->where($target);
            $statement = $sql->prepareStatementForSqlObject($deleteMarkerLinker);
            $statement->execute();

            $deletePeriodLinker = $sql->delete()->from('period')->where($target);
            $statement = $sql->prepareStatementForSqlObject($deletePeriodLinker);
            $statement->execute();

            $deletePeriodLinker = $sql->delete()->from('prestation')->where($target);
            $statement = $sql->prepareStatementForSqlObject($deletePeriodLinker);
            $statement->execute();

            $this->adapter->getDriver()->getConnection()->commit();
        } catch (\Exception $error ){
            var_dump($error);
            $this->adapter->getDriver()->getConnection()->rollback();
        }
    }


    /**
     * @param $data
     * @return false|mixed
     */
    public function isRecordExist($data)
    {

        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $sql = $this->getSql();
        $select = $sql->select();
        $select
            ->from(array('p'=> 'prestation'))
            ->columns(array('p_id'))
            ->join(
                array('ml' => 'marker_linker'),
                'ml.p_id = p.p_id',
                array('*'),
                $select::JOIN_INNER
            )
            ->join(
                array('m' => 'marker'),
                'ml.m_id = m.m_id',
                array('*'),
                $select::JOIN_INNER
            )
            ->join(
                array('t' => 'type'),
                't.t_id = p.t_id',
                array('*'),
                $select::JOIN_INNER
            )
            ->join(
                array('l' => 'locality'),
                'l.l_id = m.l_id',
                array('*'),
                $select::JOIN_INNER
            )

            ->where(array(
                'p.p_name' => $data['name'],
                'p.t_id' => $data['type'],
                'l.l_name' => $data['locality']
                /*'p.p_id' => $prestation->getId(),
                'pd.pd_start <= ?' => $period->getPdStart(),
                'pd.pd_end >= ?' => $period->getPdEnd(),
                'h.h_start = ?' => $horaire->getHStart()*/
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $results = $statment->execute();
        return $results->current();
    }

    public function fetchByHoraire($time, $id = null)
    {
        $target = [
            'pd.pd_start <= ?' => DateManipulation::convertDateStringToDate($time['start']),
            'pd.pd_end >= ?' => DateManipulation::convertDateStringToDate($time['end']),
            'h.h_day' => DateManipulation::convertDateStringToWeekDay($time['start']),
            'h.h_start <= ?' => DateManipulation::convertDateStringToTime($time['start']),
            'h.h_end >= ?' => DateManipulation::convertDateStringToTime($time['end']) ];

        if ($id) $target['p.p_id'] = $id;

        $sql= new \Zend\Db\Sql\Sql($this->adapter);
        $select  = $sql->select();
        $select->from(array('p' => $this->table))
            ->columns(
                array('*')
            )
            ->join(
                array('pd' => 'period'),
                'p.p_id = pd.p_id',
                array(
                    'pd_start',
                    'pd_end',
                    'pd_business_weekday'
                ),
                $select::JOIN_LEFT
            )
            ->join(
                array('h' => 'horaire'),
                'h.pd_id = pd.pd_id',
                array(
                    'h_start',
                    'h_end',
                    'h_day'
                ),
                $select::JOIN_LEFT
            )
            ->where($target);


        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet($this->getHydrator(), new Prestation());
        $resultSet->initialize($result);
        return ( $resultSet->count() > 0 ) ? $resultSet->current() : null;
    }


}