<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 14:28
 */

namespace Prestation\Repository;


use Prestation\Entity\Horaire;
use Prestation\Entity\Hydrator\HoraireHydrator;
use Prestation\Entity\Hydrator\PeriodHydrator;
use Prestation\Utils\DateManipulation;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class HoraireRepositoryImpl implements HoraireRepository
{

    use AdapterAwareTrait;
    protected $table = 'horaire';

    /**
     * @param \Prestation\Entity\Horaire $horaire
     * @return int|null
     */
    public function save($horaire)
    {
        // TODO: Implement save() method.

        $h_id = null;
        $values = array(
            'h_start' => $horaire->getHStart(),
            'h_end' => $horaire->getHEnd(),
            'h_day' => $horaire->getHDay(),
            'pd_id' => $horaire->getPdId(),
        );
        //var_dump($values);

        try {
            $this->adapter->getDriver()->getConnection()->beginTransaction();

            $sql = new \Zend\Db\Sql\Sql($this->adapter);
            $insert = $sql->insert()
                ->values($values)
                ->into($this->table);
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();

            $h_id = $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();



            $this->adapter->getDriver()->getConnection()->commit();

        } catch (\Exception $e ) {
            $this->adapter->getDriver()->getConnection()->rollback();

        }
        return $h_id;
    }

    /**
     * @param $data
     * @return mixed|null
     */
    public function findBy($data)
    {
        $sql = $this->getSql();
        $select = $sql->select();
        $select
            ->from(array('pd'=> $this->table))
            ->columns(array(
                'h_id',
                'h_start',
                'h_end',
                'h_day',
                'pd_id',
                /*                   'pd_provider',
                                   'pd_week_start',
                                   'pd_week_end',
                                   'p_id_prestation',
                                   'pd_level_categories' => SQLPeriodHelper::getLevelCategoriesSql($sql),
                                   'pd_age_categories' => SQLPeriodHelper::getAgeCategoriesSql($sql),
                                   'pd_subtypes' => SQLPeriodHelper::getSubtypesSql($sql)*/
            ))
            ->where(array(
                'h_start = ?' => $data['start'],
                'h_end = ?' => $data['end'],
                'pd_id = ?' => $data['pd_id']
            ));

        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet( new HoraireHydrator(), new Horaire());
        $resultSet->initialize($result);

        return $resultSet->count() > 0? $resultSet->current(): null;
    }
    /**
     * @param $time
     * @param $pd_id
     * @return mixed
     */
    public function findByTime($time, $pd_id)
    {
        $target = [
            'h.pd_id' => $pd_id,
            'h.h_day' => DateManipulation::convertDateStringToWeekDay($time['start']),
            'h.h_start <= ?' => DateManipulation::convertDateStringToTime($time['start']),
            'h.h_end >= ?' => DateManipulation::convertDateStringToTime($time['end']) ];

        $sql = $this->getSql();
        $select = $sql->select();
        $select
            ->from(array('h'=> $this->table))
            ->columns(array(
                'h_id',
                'h_start',
                'h_end',
                'h_day',
                'pd_id',
            ))
            ->where($target);

        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet( new HoraireHydrator(), new Horaire());
        $resultSet->initialize($result);

        return $resultSet->count() > 0? $resultSet->current(): null;
    }
    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }


}