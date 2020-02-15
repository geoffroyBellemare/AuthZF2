<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 23:51
 */

namespace Prestation\Service;


interface MarkerService
{
    /**
     * @param array $data
     * @return mixed
     */
    public function save($data);
}