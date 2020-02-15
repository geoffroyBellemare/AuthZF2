<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/10/2018
 * Time: 17:05
 */

namespace Prestation\Repository;


use Prestation\Repository\RepositoryInterface;

interface AliasesRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\Aliases $aliases
     * @return int|null
     */
    public function create($aliases);

    /**
     * @param string $name
     * @return \Prestation\Entity\Aliases|null
     */
    public function findByName($name);
}