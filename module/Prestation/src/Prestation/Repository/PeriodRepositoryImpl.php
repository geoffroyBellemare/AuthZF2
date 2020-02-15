<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 26/05/2019
 * Time: 18:39
 */

namespace Prestation\Repository;


use Prestation\Entity\Hydrator\PeriodHydrator;
use Prestation\Entity\Period;
use Prestation\Utils\BitManipulation;
use Prestation\Utils\DateManipulation;
use Prestation\Utils\SQLPeriodHelper;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class PeriodRepositoryImpl implements PeriodRepository
{
    use AdapterAwareTrait;
    private $table = 'period';

    /**
     * @param \Prestation\Entity\Period $period
     * @return int|null
     */
    public function save($period)
    {
        $pd_id = null;
        $values = array(
            'pd_start' => $period->getPdStart(),
            'pd_end' => $period->getPdEnd(),
            'pd_year' => $period->getPdYear(),
            'pd_business_weekday' => $period->getPdBusinessWeekday(),
            'pd_price' => $period->getPdPrice(),
            'pd_quantity' => $period->getPdQuantity(),
            'p_id' => $period->getPId(),
        );
        if($period->getPIdPrestation()) $values['p_id_prestation'] = $period->getPIdPrestation();

        /*            $this->createRelWithAgeCategory($period->getPdAgeCategory(), $pd_id);
                    $this->createRelWithLevelCategory($period->getPdLevelCategory(), $pd_id);
                    $this->createRelWithSubType($period->getPdSubtypes(), $pd_id);*/
       try {
            $this->adapter->getDriver()->getConnection()->beginTransaction();

            $sql = new \Zend\Db\Sql\Sql($this->adapter);
            $insert = $sql->insert()
                    ->values($values)
                    ->into($this->table);
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();

            $pd_id = $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();

            $this->adapter->getDriver()->getConnection()->commit();

        } catch (\Exception $e ) {
           var_dump($e->getMessage());
            $this->adapter->getDriver()->getConnection()->rollback();

        }
        return $pd_id;

    }

    /**
     * @param $data
     * @param null $p_id
     * @return mixed|null|object
     */
    public function findBy($data, $p_id = null)
    {
        $dateFormat = 'Y-m-d G:i:s';
        // formaet : Y-m-d G:i:s
        //timeStamp:  mktime(date("H"), date("i"), date("s"), date("n"), date("j")+30, date("Y"));

        //date($dateFormat, $timestamp);
        //$startDate = \DateTime::createFromFormat('Y-m-d g:i:s', '2019-05-27 00:00:00');

/*        $week_sunday_date = date("Y-m-d\TH:i:sP",strtotime('this sunday'));
        $satruday_date = date("Y-m-d\TH:i:sP",strtotime("+6 day", strtotime($week_sunday_date)));*/
//WARNING VERIFIER LES COMTES DES SSTYPES EN BAS SONT EGAUX

        $sql = $this->getSql();
        $select = $sql->select();
        $select
            ->from(array('pd'=> $this->table))
            ->columns(array(
                   'pd_id',
                   'pd_start',
                   'pd_end',
                   'pd_year',
                   'pd_business_weekday',
                   'pd_price',
                   'pd_quantity',
                   'p_id',
/*                   'pd_provider',
                   'pd_week_start',
                   'pd_week_end',
                   'p_id_prestation',
                   'pd_level_categories' => SQLPeriodHelper::getLevelCategoriesSql($sql),
                   'pd_age_categories' => SQLPeriodHelper::getAgeCategoriesSql($sql),
                   'pd_subtypes' => SQLPeriodHelper::getSubtypesSql($sql)*/
            ))
            ->having(SQLPeriodHelper::getPredicateSetPeriodExistingSql($data));

        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet( new PeriodHydrator(), new Period());
        $resultSet->initialize($result);

        return $resultSet->count() > 0? $resultSet->current(): null;
    }

    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }

    /**
     * @param \Prestation\Entity\AgeCategory[] $ageCategoryList
     * @param $p_id
     */
    public function createRelWithAgeCategory($ageCategoryList, $pd_id = null ) {

        if( $ageCategoryList ) {

            foreach ($ageCategoryList as $ageCategory ) {
                $sql = $this->getSql();
                $insert = $sql->insert()
                    ->into('period_age_linker')
                    ->values(array(
                        'pd_id' => $pd_id,
                        'c_a_id' => $ageCategory->getId()
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
    public function createRelWithLevelCategory($levelCategoryList, $pd_id = null)
    {
        if( $levelCategoryList ) {

            foreach ($levelCategoryList as $levelCategory ) {
                $sql = $this->getSql();
                $insert = $sql->insert()
                    ->into('period_level_linker')
                    ->values(array(
                        'pd_id' => $pd_id,
                        'c_l_id' => $levelCategory->getId()
                    ));
                $statment = $sql->prepareStatementForSqlObject($insert);
                $statment->execute();
            }
        }
    }

    /**
     * @param \Prestation\Entity\SubType[] $subTypes
     * @param int $pd_id
     */
    public function createRelWithSubType($subTypes, $pd_id)
    {
        foreach ($subTypes as $subType) {
            $sql = new \Zend\Db\Sql\Sql($this->adapter);
            $insert = $sql->insert('period_sub_type_linker')
                ->values(array(
                    'pd_id' => $pd_id,
                    'st_id' => $subType->getId()
                ));
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
        }
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $target = array('pd_id' => $id);
        $sql = new \Zend\Db\Sql\Sql($this->adapter);

        try {
            $this->adapter->getDriver()->getConnection()->beginTransaction();

            $deleteSubTypeLinker = $sql->delete()->from('period_sub_type_linker')->where($target);
            $statement = $sql->prepareStatementForSqlObject($deleteSubTypeLinker);
            $statement->execute();

            $deleteAgeLinker = $sql->delete()->from('period_age_linker')->where($target);
            $statement = $sql->prepareStatementForSqlObject($deleteAgeLinker);
            $statement->execute();

            $deleteLevelLinker = $sql->delete()->from('period_level_linker')->where($target);
            $statement = $sql->prepareStatementForSqlObject($deleteLevelLinker);
            $statement->execute();

            $deletePeriodLinker = $sql->delete()->from('period')->where($target);
            $statement = $sql->prepareStatementForSqlObject($deletePeriodLinker);
            $statement->execute();

            $this->adapter->getDriver()->getConnection()->commit();
        } catch (\Exception $error ){
            var_dump($error);
            $this->adapter->getDriver()->getConnection()->rollback();
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $sql = $this->getSql();
        $select = $sql->select();
        $select->from(array('pd'=> $this->table))
            ->columns(array('*'))
            ->where(array('pd_id = ?' => $id));

        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet( new PeriodHydrator(), new Period());
        $resultSet->initialize($result);

        return $resultSet->toArray();
    }

    /**
     * @param $time
     * @param null $p_id
     * @return Period[]|mixed
     */
    public function findByDate($time, $p_id = null)
    {
        $target = [
            'pd.pd_start <= ?' => DateManipulation::convertDateStringToDate($time['start']),
            'pd.pd_end >= ?' => DateManipulation::convertDateStringToDate($time['end']),
         ];

        if ($p_id) $target['pd.p_id'] = $p_id;

        $sql= new \Zend\Db\Sql\Sql($this->adapter);
        $select  = $sql->select();
        $select->from(array('pd' => $this->table))
            ->columns(
                array('*')
            )
            ->where($target);


        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new PeriodHydrator(), new Period());
        $resultSet->initialize($result);
        return ( $resultSet->count() > 0 ) ? $resultSet : null;
    }
    /**
     * @param $p_id
     * @param $pd_id
     * @param $p_host_id
     * @param $p_host_price
     * @@return false|mixed
     */
    public function rent($p_id, $pd_id, $p_host_id, $p_host_price = null){
        var_dump("LOCATION: d un autre prestatuio");
        $values = array(
            'p_id' => $p_id,
            'pd_id' => $pd_id,
            'p_id_prestation' => $p_host_id,
            'location_price' => $p_host_price
        );
        $sql = $this->getSql();
        $insert = $sql->insert()
            ->into('louer')
            ->values($values);
        $statment = $sql->prepareStatementForSqlObject($insert);
        $statment->execute();
    }


}