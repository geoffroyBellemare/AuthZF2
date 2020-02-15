<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 05/09/2018
 * Time: 18:15
 */

namespace Prestation\Service;


use Prestation\Entity\SubType;

interface SubTypeService
{
    /**
     * @param \Prestation\Entity\SubType $subType
     * @return mixed
     */
    public function save($subType);

    /**
     * @return SubType[] $subTypes
     */
    public function fetch();

    /**
     * @param $id
     * @return SubType $subType|null
     */
    public function findById($id);

    /**
     * @param \Prestation\Entity\SubType $subType
     * @return mixed
     */
    public function update($subType);
}