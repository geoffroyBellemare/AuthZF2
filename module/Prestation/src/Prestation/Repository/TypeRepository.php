<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 19/10/2018
 * Time: 14:00
 */

namespace Prestation\Repository;


use Application\Repository\RepositoryInterface;

interface TypeRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\Type $type
     * @return mixed
     */
    public function create($type);

    /**
     * @param string $name
     * @return \Prestation\Entity\Type
     */
    public function findByName($name);
}