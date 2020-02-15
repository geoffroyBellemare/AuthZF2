<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/10/2018
 * Time: 16:24
 */

namespace Prestation\Repository;


use Application\Repository\RepositoryInterface;

interface AgeCategoryRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\AgeCategory $category
     * @return mixed
     */
    public function create($category);

    /**
     * @param $name
     * @return mixed|null
     */
    public  function findByName($name);
}