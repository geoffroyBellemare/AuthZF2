<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/06/2019
 * Time: 22:18
 */

namespace Prestation\Repository;


interface CRUDInterface extends RepositoryInterface
{
    /**
     * @param object $object
     * @return int|null
     */
    public function create($object);

    /**
     * @param $name
     * @return mixed|null
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
     * @return object
     */
    public function fetchById($id);
}