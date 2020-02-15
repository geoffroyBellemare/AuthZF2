<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 16:16
 */

namespace Prestation\Service;


interface DepartementService
{
    /**
     * @param $data
     * @return \Prestation\Entity\Departement
     */
    public function save($data);

    /**
     * @param \Prestation\Entity\Departement $departement
     * @param \Prestation\Entity\Marker $marker
     * @return mixed
     */
    public function saveRelation($departement, $marker);
}