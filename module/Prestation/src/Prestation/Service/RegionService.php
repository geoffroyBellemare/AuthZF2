<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 11:22
 */

namespace Prestation\Service;


interface RegionService
{
    /**
     * @param $data
     * @return \Prestation\Entity\Region
     */
    public function save($data);

    /**
     * @param \Prestation\Entity\Region $region
     * @param \Prestation\Entity\Marker $marker
     * @return mixed
     */
    public function saveRelation($region, $marker);
}