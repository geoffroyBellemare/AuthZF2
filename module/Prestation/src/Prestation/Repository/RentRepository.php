<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/06/2019
 * Time: 16:00
 */

namespace Prestation\Repository;


interface RentRepository extends RepositoryInterface
{
    /**
     * @param $p_id
     * @param $pd_id
     * @param $p_host_id
     * @param $p_host_price
     * @@return false|mixed
     */
    public function save($p_id, $pd_id, $p_host_id, $p_host_price);

    /**
     * @param $data
     * @return false|mixed
     */
    public function isFree($data);
}