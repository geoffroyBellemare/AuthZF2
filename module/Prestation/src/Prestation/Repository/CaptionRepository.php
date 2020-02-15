<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 28/06/2019
 * Time: 18:20
 */

namespace Prestation\Repository;


use Prestation\Entity\Caption;

interface CaptionRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\Caption $object
     * @return int|null
     */
    public function create($object);

    /**
     * @param $name
     * @return Caption|null
     */
    public function findByName($name);

    /**
     * @param $id
     * @return void
     */
    public function delete($id);

    /**
     * @param object $object
     * @return mixed
     */
    public function update($object);

    /**
     * @param $id
     * @return Caption
     */
    public function fetchById($id);
}