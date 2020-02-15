<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 04/07/2019
 * Time: 22:11
 */

namespace Prestation\Service;


use Prestation\Entity\Prestataire;
use Prestation\Entity\Prestation;
use Prestation\Entity\User;

interface ReservationService
{
    /**
     * @param [] $data
     * @param User $client
     * @param Prestation|null $prestation
     * @param Prestataire|null $prestataire
     * @return mixed
     */
    public function create($data, $client, Prestation $prestation = null, $prestataire = null);

    /**
     * @param $id
     * @param null $time
     * @return mixed
     */
    public function isPrestationFReeSpace($id, $time = null);

    /**
     * @param $id
     * @return mixed
     */
    public function isPrestataireFree($id, $time);
}