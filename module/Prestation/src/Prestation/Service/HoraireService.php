<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 14:33
 */

namespace Prestation\Service;


interface HoraireService
{
    /**
     * @param [] $data
     * @param int $pd_id
     * @return mixed
     */
    public function save($data, $pd_id);
}