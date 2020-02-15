<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 05/09/2018
 * Time: 18:06
 */

namespace Prestation\Repository;


use Application\Repository\RepositoryInterface;
use Prestation\Entity\SubType;

interface SubTypeRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\SubType $subType
     * @return mixed
     */
    public function save($subType);

    /**
     * @return \Prestation\Entity\SubType[] $subType
     */
    public function fetch();

    /**
     * @param $id
     * @return SubType $subType
     */
    public function findById($id);

    /**
     * @param $name
     * @return \Prestation\Entity\SubType|null
     */
    public function  findByName($name);
    /**
     * @param \Prestation\Entity\SubType $subType
     * @return mixed
     */
    public function update($subType);
}