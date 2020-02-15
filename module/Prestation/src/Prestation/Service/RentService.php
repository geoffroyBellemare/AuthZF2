<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/06/2019
 * Time: 16:19
 */

namespace Prestation\Service;


interface RentService
{
    /**
     * @param \Prestation\Entity\Prestation $prestation
     * @param \Prestation\Entity\Period $period
     * @param float $price
     * @@return false|mixed
     */
    public function save($prestation, $period, $price);


}