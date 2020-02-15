<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 19:22
 */

namespace Prestation\Repository;


use Application\Repository\RepositoryInterface;

interface MarkerRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\Marker $marker
     * @return int|null
     */
    public function create($marker);

    /**
     * @param $lat
     * @param $lng
     * @return \Prestation\Entity\Marker|null
     */
    public function findBy($lat, $lng);

    /**
     * @param \Prestation\Entity\Marker $marker
     * @param \Prestation\Entity\Prestation $prestation
     * @return mixed
     */
    public function createRelation($marker, $prestation);
}