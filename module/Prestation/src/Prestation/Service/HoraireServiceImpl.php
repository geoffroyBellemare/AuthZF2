<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 14:35
 */

namespace Prestation\Service;


use Prestation\Entity\Horaire;
use Prestation\Utils\DateManipulation;

class HoraireServiceImpl implements HoraireService
{
    /**
     * @var \Prestation\Repository\HoraireRepository
     */
    protected $horaireRepo;
    /**
     * @var \Prestation\Service\PrestataireService
     */
    protected $prestataireService;

    /**
     * HoraireServiceImpl constructor.
     * @param \Prestation\Repository\HoraireRepository $horaireRepo
     * @param PrestataireService $prestataireService
     */
    public function __construct(\Prestation\Repository\HoraireRepository $horaireRepo, PrestataireService $prestataireService)
    {
        $this->horaireRepo = $horaireRepo;
        $this->prestataireService = $prestataireService;
    }


    /**
     * @param [] $data
     * @param int $pd_id
     * @return mixed
     */
    public function save($data, $pd_id)
    {
        $values = $data['periods'][0]['horaire'];

        //TODO CHECK if PROVIDER is free for that period
        //
/*        $pvr_id = $values[0]['provider'];
        $start = $values[0]['start'];*/
       // $this->prestataireService->isFree($pvr_id, $start);
        //$end = DateManipulation::convertDateStringToTime($values[0]['end']);
//var_dump(DateManipulation::convertDateStringToTime($values[0]['start']));
/*        $horaires = array_map(function( $day, $times) use($pd_id) {
           return  array_map(function($time) use ($pd_id, $day){
               $horaire = new Horaire();
               $horaire->setHDay(DateManipulation::convertDateStringToWeekDay($day));
               $horaire->setPdId($pd_id);
               $horaire->setHStart(DateManipulation::convertDateStringToTime($time['start']));
               $horaire->setHEnd(DateManipulation::convertDateStringToTime($time['end']));
               $horaire->setHProvider($time['provider']);
               return $horaire;
           }, $times);
        }, array_keys($values), array_values($values));*/

        $horaires = array_map(function( $h) use($pd_id) {
            $horaire = new Horaire();
            $horaire->setHDay(DateManipulation::convertDateStringToWeekDay($h['start']));
            $horaire->setHStart(DateManipulation::convertDateStringToTime($h['start']));
            $horaire->setHEnd(DateManipulation::convertDateStringToTime($h['end']));
            $horaire->setPdId($pd_id);
            $horaire->setHProvider($h['provider']);
            return $horaire;

        }, $values);
        /**
         * @var  Horaire $horaire
         */
        $horaire = $horaires[0];
        $horaire->setHId($this->horaireRepo->save($horaire));
        return $horaire;

    }
}