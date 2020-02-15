<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 04/07/2019
 * Time: 20:42
 */

namespace Prestation\Repository;


use Prestation\Entity\Prestataire;
use Prestation\Entity\Prestation;
use Prestation\Entity\Reservation;
use Prestation\Entity\User;

interface ReservationRepository extends RepositoryInterface
{
    /**
     * @param Reservation $reservation
     * @return mixed
     */
    public function create($reservation);

    /**
     * @param $id
     * @param null $time
     * @return mixed
     */
    public function findByPID($id, $time = null);


    /**
     * @param $id
     * @return mixed
     */
    public function findByPrestataire($id);

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);
}