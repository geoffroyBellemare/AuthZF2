<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 20:44
 */

namespace Prestation\Service;


use Prestation\Entity\Horaire;
use Prestation\Entity\Period;
use Prestation\Entity\Prestataire;
use Prestation\Utils\DateManipulation;

class PrestataireServiceImpl implements PrestataireService
{
    /**
     * @var \Prestation\Repository\PrestataireRepository
     */
    protected $prestataireRepo;

    /**
     * PrestataireServiceImpl constructor.
     * @param \Prestation\Repository\PrestataireRepository $prestataireRepo
     */
    public function __construct(\Prestation\Repository\PrestataireRepository $prestataireRepo)
    {
        $this->prestataireRepo = $prestataireRepo;
    }


    /**
     * @param $pvr_id
     * @param $date
     * @return mixed
     */
    public function isFree($pvr_id, $date)
    {
        // TODO: Implement isFree() method.
        $provider = new Prestataire();
        $provider->setPvrId($pvr_id);
        $horaire = new Horaire();
        $horaire->setHStart(DateManipulation::convertDateStringToTime($date));
        $horaire->setHEnd(DateManipulation::convertDateStringToTime($date));
        $period = new Period();
        $period->setPdStart(DateManipulation::convertDateStringToDate($date));
        $period->setPdEnd(DateManipulation::convertDateStringToDate($date));
        return $this->prestataireRepo->isFree($provider, $horaire, $period);
    }


    /**
     * @param []$data
     * @return false|mixed
     */
    public function isHostFree($period)
    {
        if(!isset($period['p_host_id']))return true;

        $isFree = true;
        //TODO WARNING RESERVATION/LOCALITION/ACCEUIL MISSING RESERVATION
        //B)TOTAL LOCATION + TOTAL RESERVATION < PRESTATION QUANTITY
        foreach ($period['horaire'] as $horaire ) {
            $time_slot = $this->prestataireRepo->isHostFree($period, $horaire);
            if(isset($time_slot['p_id']) ){
                if( $time_slot['remaining_quantity'] + $period['quantity'] > $time_slot['p_host_quantity']) {
                    var_dump('prestation hote a plus de  place choisir un autre crenneux');
                    $isFree = false;
                }
            }
        }

        return $isFree;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function isHostOpen($period)
    {
        if(!isset($period['p_host_id']))return false;

        $isOpen = true;
        foreach ($period['horaire'] as $horaire ) {
            $time_slot = $this->prestataireRepo->isHostOpen($period, $horaire);
            if (!$time_slot) $isOpen = false;
        }

        return $isOpen;
    }
}