<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 26/05/2019
 * Time: 19:09
 */

namespace Prestation\Service;


use Prestation\Entity\Period;

interface PeriodService
{
    /**
     * @param $data
     * @param \Prestation\Entity\Prestation $prestation
     * @param \Prestation\Entity\SubType[] $subtypes
     * @param \Prestation\Entity\AgeCategory[] $ageCategories
     * @param \Prestation\Entity\LevelCategory[] $levelCategories
     * @return Period[]|null
     */
    public function save($data, $prestation, $subtypes, $ageCategories, $levelCategories);
    /**
     * @param $id
     * @return void
     */
    public function delete($id);


    /**
     * @param \Prestation\Entity\Prestation $prestation
     * @param \Prestation\Entity\Period $period
     * @param float $price
     * @@return false|mixed
     */
    public function rent($prestation, $period, $price);


}