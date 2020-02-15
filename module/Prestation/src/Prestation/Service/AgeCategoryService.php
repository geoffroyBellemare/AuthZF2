<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/10/2018
 * Time: 17:08
 */

namespace Prestation\Service;


interface AgeCategoryService
{
    /**
     * @param $data
     * @return \Prestation\Entity\AgeCategory
     */
    public function save($data);
}