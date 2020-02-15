<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/06/2019
 * Time: 11:52
 */

namespace Prestation\Repository;


interface SportCategoryRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\SportCategory $sports
     * @return null|int
     */
    public function save($sports);
}