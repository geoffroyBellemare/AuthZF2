<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 23:51
 */

namespace Prestation\Service;


interface MarkerService
{
    /**
     * @param array $data
     * @param \Prestation\Entity\Country $country
     * @param \Prestation\Entity\Locality $locality
     * @param \Prestation\Entity\Departement $department
     * @param \Prestation\Entity\Region $region
     * @return mixed
     */
    public function save($data, $country, $locality, $department, $region);

}