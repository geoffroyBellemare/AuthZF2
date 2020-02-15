<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/06/2019
 * Time: 12:47
 */

namespace Prestation\Service;


use Prestation\Entity\SportCategory;

interface CRUDInterface
{
    /**
     * @param $data
     * @return mixed|null
     */
    public function save($data);

    /**
     * @param $id
     * @return void
     */
    public function delete($id);

    /**
     * @param $id
     * @return mixed
     */
    public function update($id);

    /**
     * @param $id
     * @return mixed
     */
    public function fetchById($id);

    /**
     * @return []mixed
     */
    public function fetchAll();

}