<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/06/2019
 * Time: 12:47
 */

namespace Prestation\Service;


use Prestation\Entity\Address;
use Prestation\Entity\SportCategory;

interface AddressService
{
    /**
     * @param $data
     * @param $l_id
     * @param $c_id
     * @param $d_id
     * @param $r_id
     * @return Address|null
     */
    public function save($data, $l_id, $c_id, $d_id, $r_id);

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