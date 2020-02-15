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
     * @param \Prestation\Entity\Marker $marker
     * @return \Prestation\Entity\Region
     */
    public function save($data);

}