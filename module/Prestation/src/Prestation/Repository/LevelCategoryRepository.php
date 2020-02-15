<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/10/2018
 * Time: 11:41
 */

namespace Prestation\Repository;


use Application\Repository\RepositoryInterface;

interface LevelCategoryRepository extends RepositoryInterface
{
    /**
     * @param $levelCategory
     * @return mixed
     */
    public function create($levelCategory);

    /**
     * @param $name
     * @return mixed
     */
    public function findByName($name);
}