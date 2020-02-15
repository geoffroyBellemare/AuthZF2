<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 26/05/2019
 * Time: 19:11
 */

namespace Prestation\Service;


use Prestation\Entity\AgeCategory;
use Prestation\Entity\Horaire;
use Prestation\Entity\LevelCategory;
use Prestation\Entity\Period;
use Prestation\Entity\Prestation;
use Prestation\Entity\SubType;
use Prestation\Utils\BitManipulation;
use Prestation\Utils\DateManipulation;

class PeriodServiceImpl implements PeriodService
{
    /**
     * @var \Prestation\Repository\PeriodRepository
     */
    protected $periodRepo;
    /**
     * @var \Prestation\Repository\HoraireRepository
     */
    protected $horaireRepo;

    /**
     * PeriodServiceImpl constructor.
     * @param \Prestation\Repository\PeriodRepository $periodRepo
     * @param \Prestation\Repository\HoraireRepository $horaireRepo
     */
    public function __construct(\Prestation\Repository\PeriodRepository $periodRepo, \Prestation\Repository\HoraireRepository $horaireRepo)
    {
        $this->periodRepo = $periodRepo;
        $this->horaireRepo = $horaireRepo;
    }


    /**
     * @param $data
     * @param \Prestation\Entity\Prestation $prestation
     * @param \Prestation\Entity\SubType[] $subtypes
     * @param \Prestation\Entity\AgeCategory[] $ageCategories
     * @param \Prestation\Entity\LevelCategory[] $levelCategories
     * @return Period[]|null
     */
    public function save($data, $prestation, $subtypes, $ageCategories, $levelCategories)
    {
        $planning = [];
        $period = null;
        $values = $data['periods'][0];
        foreach ($data['periods'] as $key => $values) {
            /*
            $values['subTypes'] = array_map(function(SubType $subtype) {return $subtype->getId();}, $subtypes);
        $values['ageCategories'] = array_map(function(AgeCategory $age) {return $age->getId();}, $ageCategories);
        $values['levelCategories'] = array_map(function(LevelCategory $level) {return $level->getId();}, $levelCategories);*/
            $values['business_weekday'] = BitManipulation::getBusinessWeekDaysInt($values['business_weekday']);
            $values['p_id'] = $prestation->getId();
            $period = $this->periodRepo->findBy($values);
            if(!$period) {
                $period = new Period();
                $period->setPdStart($values['start']);
                $period->setPdEnd($values['end']);
                $period->setPdYear($values['year']);
                $period->setPdBusinessWeekday($values['business_weekday']);
                $period->setPdPrice($values['price']);
                $period->setPdQuantity($values['quantity']);
                $period->setPId($prestation->getId());
                $period->setPIdPrestation(isset($values['p_id_prestation']) ? $values['p_id_prestation']:null);

               $period->setPdId($this->periodRepo->save($period));
            }

                /*
                  $period->setPdWeekStart($values['week_start']);
                  $period->setPdWeekEnd($values['week_end']);
                  $period->setPdAgeCategory($ageCategories);
                  $period->setPdLevelCategory($levelCategories);
                  $period->setPdSubtypes($subtypes);
                */

                /*            if (isset($values['p_host_id']))
                            $period->setPHostId($values['p_host_id']);*/

                // $period->setPdId($this->periodRepo->save($period, $prestation));

            if (!$period->getPdId()) continue;
            $horaires = [];
            foreach ($values['horaire'] as $k => $h) {
                $h['pd_id'] = $period->getPdId();
                $horaire = $this->horaireRepo->findBy($h);
                if (!$horaire) {
                    $horaire = new Horaire();
                    $horaire->setHDay(DateManipulation::convertDateStringToWeekDay($h['start']));
                    $horaire->setHStart(DateManipulation::convertDateStringToTime($h['start']));
                    $horaire->setHEnd(DateManipulation::convertDateStringToTime($h['end']));
                    $horaire->setPdId($period->getPdId());
                    $horaire->setHId($this->horaireRepo->save($horaire));
                }

                if (!$horaire->getHId()) continue;
                $horaires[] = $horaire;

            }
            $period->setHoraires($horaires);
            $planning[] = $period;
        }
 /*$this->periodRepo->findBy($values)*/;


/*        if($period->getPHostId()) {
            $this->rent($prestation, $period, 15);
        }*/
        return $planning;
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $this->periodRepo->delete($id);
    }


    /**
     * @param \Prestation\Entity\Prestation $prestation
     * @param \Prestation\Entity\Period $period
     * @param float $price
     * @@return false|mixed
     */
    public function rent($prestation, $period, $price)
    {
        // si hote n est pas defini alors p_id_prestation == prestationID
        // si pas de prestataire entree libre

            $this->periodRepo->rent($prestation->getId(), $period->getPdId(), $period->getPHostId(), 15);

    }


}