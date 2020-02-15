<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 04/07/2019
 * Time: 22:47
 */

namespace Prestation\Service;


use Prestation\Entity\Prestataire;
use Prestation\Entity\Prestation;
use Prestation\Entity\Reservation;
use Prestation\Entity\User;
use Prestation\Repository\PrestationRepository;
use Prestation\Repository\ReservationRepository;
use Prestation\Utils\DateManipulation;

class ReservationServiceImpl implements ReservationService
{
    /**
     * @var \Prestation\Repository\ReservationRepository
     */
    protected $reservationRepo;
    /**
     * @var \Prestation\Repository\PrestationRepository
     */
    protected $prestationRepo;

    /**
     * ReservationServiceImpl constructor.
     * @param ReservationRepository $reservationRepo
     */
    public function __construct(ReservationRepository $reservationRepo, PrestationRepository $prestationRepository)
    {
        $this->reservationRepo = $reservationRepo;
        $this->prestationRepo = $prestationRepository;
    }

    /**
     * @param [] $data
     * @param User $client
     * @param Prestation|null $prestation
     * @param Prestataire|null $prestataire
     * @return mixed
     */
    public function create($data, $client, Prestation $prestation = null, $prestataire = null)
    {
        // TODO: Implement create() method.
        foreach ($data['periods'] as $key => $values) {
            if( isset($values['p_id_prestation']) ) {
                foreach ($values['horaire'] as $k => $h) {
                   $reservation = new Reservation();
                   $reservation->setRvStart(DateManipulation::convertDateStringToTimeStamp($h['start']));
                   $reservation->setRvEnd(DateManipulation::convertDateStringToTimeStamp($h['end']));
                   $reservation->setRvQuantity($data['quantity']);
                   $reservation->setUserId($client->getUserId());
                   $reservation->setPId($values['p_id_prestation']);


                   $reservation->setRvId($this->reservationRepo->create($reservation));
                   var_dump($reservation);

                }
            }
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function isPrestationFReeSpace($id, $time = null)
    {
        $reservation = $this->reservationRepo->findByPID($id);
        $prestation = $this->prestationRepo->fetchByid($id);

        if ($prestation->getQuantity() >= count($reservation) )
            return true;
        else
            return false;

    }

    /**
     * @param $id
     * @return mixed
     */
    public function isPrestataireFree($id, $time)
    {
        // TODO: Implement isPrestataireFree() method.
    }
}