<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 17:25
 */

namespace Prestation\Service;


use Prestation\Entity\Locality;

interface LocalityService
{
    /**
     * @param $data
     * @return mixed|Locality
     */
    public function save($data);

}