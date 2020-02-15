<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 16:51
 */

namespace Prestation\Repository;


use Application\Repository\RepositoryInterface;

interface LocalityRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\Locality $locality
     * @return int|null
     */
    public function create($locality);

    /**
     * @param $name
     * @return \Prestation\Entity\Locality|null
     */
    public function findByName($name);
}