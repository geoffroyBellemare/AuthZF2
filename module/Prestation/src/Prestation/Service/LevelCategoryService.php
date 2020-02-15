<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/10/2018
 * Time: 13:59
 */

namespace Prestation\Service;


interface LevelCategoryService
{
    /**
     * @param array
     * @return \Prestation\Entity\LevelCategory
     */
    public function save($data);
}