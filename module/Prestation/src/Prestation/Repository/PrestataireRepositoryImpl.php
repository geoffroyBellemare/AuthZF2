<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 19:32
 */

namespace Prestation\Repository;


use Prestation\Utils\DateManipulation;
use Prestation\Utils\SQLPrestataireHelper;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;

class PrestataireRepositoryImpl implements PrestataireRepository
{

   use AdapterAwareTrait;
   protected $table = "prestataire";

    /**
     * @param \Prestation\Entity\Prestataire $provider
     * @param \Prestation\Entity\Horaire $horaire
     * @param \Prestation\Entity\Period $period
     * @return true|false
     */
    public function isFree($provider, $horaire, $period)
    {
        $sql = $this->getSql();
        $select = $sql->select();
        $select
            ->from(array('tr'=> 'travailler'))
            ->columns(array('*'))
            ->join(
                array('pd' => 'period'),
                'tr.pd_id = pd.pd_id',
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

        ->where(array(
            'pvr_id' => $provider->getPvrId(),
            'pd.pd_start <= ?' => $period->getPdStart(),
            'pd.pd_end >= ?' => $period->getPdEnd(),
            'h.h_start = ?' => $horaire->getHStart()
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $results = $statment->execute();

       return $results->current();
    }

    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }

    /**
     * @param []$period
     * @param []$horaire
     * @return []String
     */
    public function isHostFree($period, $horaire)
    {
        //1 get the host quntity
        //2 get the count total request by the renter
        //3 ADD the reservation s
       // var_dump($period);
        var_dump('gdgdgdggdgddggdgd');
        $sql = $this->getSql();
        $select = $sql->select();
        $select
            ->from(array('lr'=> 'louer'))
            ->columns(array(
                'p_id',
                'p_id_prestation',
                'pd_id',
                'location_price',
                //'remaining_quantity' => SQLPrestataireHelper::getRemainingQuantitySql($sql),
                'p_host_quantity' => SQLPrestataireHelper::getHostProviderQuantitySql($sql)
            ))
            ->join(
                array('pd' => 'period'),
                'lr.pd_id = pd.pd_id',
                array(
                    'pd_start',
                    'pd_end',
                    'pd_quantity',
                    'remaining_quantity' => new \Zend\Db\Sql\Expression('SUM(pd_quantity)')
                ),
                $select::JOIN_INNER
            )
//WARNING QUANTITY FROM PRESTATION : should come from the prestation
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
            ->where(array(
                'lr.p_id_prestation' => $period['p_host_id'],
                'pd.pd_start <= ?' => $period['start'],
                'pd.pd_end >= ?' => $period['end'],
                'h.h_start = ?' => $horaire['start'],
                'h.h_end = ?' => $horaire['end']
            ));


        $statment = $sql->prepareStatementForSqlObject($select);
        $results = $statment->execute();
        return $results->current() ;

    }

    /**
     * @param []$period
     * @param []$horaire
     * @return false|mixed
     */
    public function isHostOpen($period, $horaire)
    {
        $sql = $this->getSql();
        $select = $sql->select();
        $select
            ->from(array('pd'=> 'period'))
            ->columns(array('*'))
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
            ->where(array(
                'pd.p_id' => $period['p_host_id'],
                'pd.pd_start <= ?' => $period['start'],
                'pd.pd_end >= ?' => $period['end'],
                'h.h_start <= ?' => $horaire['start'],
                'h.h_end >= ?' => $horaire['end']
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $results = $statment->execute();

        return $results->current() ;
    }
}