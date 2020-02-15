<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/07/2019
 * Time: 17:40
 */

namespace Prestation\Repository;


use Prestation\Entity\Entreprise;
use Prestation\Entity\Prestation;

interface VendreRepository extends RepositoryInterface
{
    /**
     * @param Entreprise $entreprise
     * @param Prestation Prestation
     * @param Prestation $spot
     * @param Period $period
     * @return mixed
     */

    public function create($entreprise, $prestation, $spot, $period);
}